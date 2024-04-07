<?php 
namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Services\SMSService;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use App\Repositories\ReadingIntervalRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadingIntervalTest extends TestCase
{

    protected $readingIntervalRepository;
    protected $smsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->readingIntervalRepository = app(ReadingIntervalRepository::class);
        $this->smsService = app(SMSService::class);
    }

    /** @test */
    public function it_creates_reading_interval_and_sends_sms()
    {

        $data = [
            'user_id' => 1, 
            'book_id' => 1,
            'start_page' => 1,
            'end_page' => 10,
        ];

        $response = $this->post('/api/v1/reading-interval', $data);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'message' => 'Success',
        ]);
    }
}
