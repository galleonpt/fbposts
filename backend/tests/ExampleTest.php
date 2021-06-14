<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ExampleTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }



    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $this->get('/');

    //     $this->assertEquals(
    //         $this->app->version(),
    //         $this->response->getContent()
    //     );
    // }

    public function testPushAndPop(): void
    {
        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack) - 1]);
        $this->assertSame(1, count($stack));

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }


    public function testEmpty(): array
    {
        $stack = [];
        $this->assertEmpty($stack);
        return $stack;
    }

    // /**
    //  * @depends testEmpty
    //  */
    // public function testPush(array $stack): array
    // {
    //     array_push($stack, 'foo');
    //     $this->assertSame('foo', $stack[count($stack) - 1]);
    //     $this->assertNotEmpty($stack);

    //     return $stack;
    // }

    // /**
    //  * @depends testPush
    //  */
    // public function testPop(array $stack): void
    // {
    //     $this->assertSame('foo', array_pop($stack));
    //     $this->assertEmpty($stack);
    // }

    // public function testOne(): void
    // {
    //     $this->assertTrue(false);
    // }

    // /**
    //  * @depends testOne
    //  */
    // public function testTwo(): void
    // {
    // }

    // public function testProducerFirst(): string
    // {
    //     $this->assertTrue(true);

    //     return 'first';
    // }

    // public function testProducerSecond(): string
    // {
    //     $this->assertTrue(true);

    //     return 'second';
    // }

    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     */
    // public function testConsumer(string $a, string $b): void
    // {
    //     $this->assertSame('first', $a);
    //     $this->assertSame('second', $b);
    // }

    /**
     * @dataProvider additionProvider
     */
    // public function testAdd(int $a, int $b, int $expected): void
    // {
    //     $this->assertSame($expected, $a + $b);
    // }

    // public function additionProvider(): array
    // {
    //     return [
    //         'adding zeros'  => [0, 0, 0],
    //         'zero plus one' => [0, 1, 1],
    //         'one plus zero' => [1, 0, 1],
    //         // 'one plus one'  => [1, 1, 3]
    //     ];
    // }

    // public function provider(): array
    // {
    //     return [['provider1'], ['provider2']];
    // }

    // public function testProducerFirst(): string
    // {
    //     $this->assertTrue(true);

    //     return 'first';
    // }

    // public function testProducerSecond(): string
    // {
    //     $this->assertTrue(true);

    //     return 'second';
    // }

    // /**
    //  * @depends testProducerFirst
    //  * @depends testProducerSecond
    //  * @dataProvider provider
    //  */
    // public function testConsumer(): void
    // {
    //     $this->assertSame(
    //         ['provider1', 'first', 'second'],
    //         func_get_args()
    //     );
    // }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
