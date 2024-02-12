<?php

namespace Brief\Compression\Tests\Unit;

use Brief\Compression\Http\Controller\CompressionController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class CompressionTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function testFileCompression()
    {
        // Mock a file for the request
        $file = UploadedFile::fake()->create('test.txt', 100);

        // Mock a request with the file
        $request = new Request();
        $request->files->add(['file' => $file]);

        // Mock the Process class to prevent actual compression
        $process = $this->getMockBuilder(Process::class)
            ->disableOriginalConstructor()
            ->getMock();
        $process->expects($this->once())
            ->method('isSuccessful')
            ->willReturn(true);

        // Mock the Process constructor to return the mocked process
        $this->mockProcessConstructor(['zip', '-r', 'compressed.zip', 'test.txt'], true, $process);

        // Create an instance of CompressionController
        $controller = new CompressionController();

        // Call the compress method
        $response = $controller->compress($request);

        // Assert that the response is a file download
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->getFile()->isFile());

        // Assert that the file is deleted after download
        $this->assertFalse(file_exists(public_path('compressed.zip')));
    }

    // Helper method to mock the Process constructor
    protected function mockProcessConstructor($cmd, $success, $process)
    {
        $this->getMockBuilder(Process::class)
            ->setConstructorArgs([$cmd])
            ->getMock();
        $process->expects($this->any())
            ->method('run')
            ->willReturn($success);
    }


}
