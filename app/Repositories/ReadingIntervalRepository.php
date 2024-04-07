<?php

namespace App\Repositories;

use App\Models\ReadingInterval;
use Illuminate\Support\Facades\DB;

class ReadingIntervalRepository
{
    protected $modelClass = ReadingInterval::class;

    public function create(array $readingIntervalData)
    {
        $this->modelClass::create($readingIntervalData);
    }
    public function getMostRecommendeBooksByReadPage()
    {
        $recursiveQuery = "
                            WITH RECURSIVE t AS (
                                SELECT
                                    book_id,
                                    start_page,
                                    MAX(end_page) AS end_page,
                                    ROW_NUMBER() OVER (PARTITION BY book_id ORDER BY start_page) AS rn
                                FROM
                                    reading_intervals
                                GROUP BY
                                    book_id,
                                    start_page
                            ),
                            r AS (
                                SELECT
                                    0 AS lvl,
                                    bu.book_id,
                                    bu.start_page,
                                    bu.end_page,
                                    bu.rn
                                FROM
                                    t bu
                                WHERE NOT EXISTS (
                                    SELECT
                                        1
                                    FROM
                                        t bu2
                                    WHERE
                                        bu2.book_id = bu.book_id AND bu2.rn < bu.rn AND bu.start_page BETWEEN bu2.start_page AND bu2.end_page
                                )
                                UNION ALL
                                SELECT
                                    lvl + 1,
                                    r.book_id,
                                    r.start_page,
                                    t.end_page,
                                    t.rn
                                FROM
                                    r
                                INNER JOIN t ON t.book_id = r.book_id AND t.rn > r.rn AND r.end_page BETWEEN t.start_page AND r.end_page
                            )
                            SELECT
                                r.book_id,
                                b.book_name,
                                SUM(r.end_page - r.start_page +1) AS num_of_read_pages
                            FROM
                                (
                                SELECT
                                    book_id,
                                    start_page,
                                    MAX(end_page) AS end_page
                                FROM
                                    r
                                GROUP BY
                                    book_id,
                                    start_page
                                ) r
                            JOIN
                                books b ON r.book_id = b.id
                            GROUP BY
                                r.book_id, b.book_name
                            ORDER BY
                                num_of_read_pages DESC
                            LIMIT 5";
        return DB::select($recursiveQuery);
    }
}
