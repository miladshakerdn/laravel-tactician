<?php

namespace Joselfonseca\LaravelTactician\Tests\Generators;

use Illuminate\Support\Facades\Artisan;
use Joselfonseca\LaravelTactician\Tests\TestCase;

/**
 * Class TestGenerators
 * @package Joselfonseca\LaravelTactician\Tests\Generators
 */
class TestGenerators extends TestCase
{

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->clearTempFiles();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->clearTempFiles();
        parent::tearDown();
    }

    /**
     * Clear the files that tests generated
     */
    protected function clearTempFiles()
    {
        if (file_exists($this->getExpectedCommandFile())) {
            unlink($this->getExpectedCommandFile());
        }

        if (file_exists($this->getExpectedHandlerFile())) {
            unlink($this->getExpectedHandlerFile());
        }
    }

    /**
     * Generate Command using Artisan
     */
    protected function makeCommand()
    {
        Artisan::call('make:tactician:command', ['name' => 'Foo']);
    }

    /**
     * Generate Handler using Artisan
     */
    protected function makeHandler()
    {
        Artisan::call('make:tactician:handler', ['name' => 'Foo']);
    }

    /**
 * @return string
 */
    protected function getExpectedCommandFile()
    {
        return __DIR__ . '/../../vendor/orchestra/testbench-core/laravel/app/CommandBus/Commands/FooCommand.php';
    }

    /**
     * @return string
     */
    protected function getExpectedHandlerFile()
    {
        return __DIR__ . '/../../vendor/orchestra/testbench-core/laravel/app/CommandBus/Handlers/FooHandler.php';
    }

    /**
     * Test Command file is created
     */
    public function test_it_creates_command()
    {
        $this->makeCommand();

        $this->assertTrue(file_exists($this->getExpectedCommandFile()));
    }

    /**
     * Test DummyClass is replaced correctly in Command
     */
    public function test_it_names_command()
    {
        $this->makeCommand();
        $this->assertTrue(strpos(file_get_contents($this->getExpectedCommandFile()), 'class FooCommand') !== false);
        $this->assertTrue(strpos(file_get_contents($this->getExpectedCommandFile()), 'FooCommand constructor') !== false);
    }

    /**
     * Test DummyNamespace is replaced correctly in Command
     */
    public function test_it_namespaces_command()
    {
        $this->makeCommand();

        $this->assertTrue(strpos(file_get_contents($this->getExpectedCommandFile()), 'namespace App\CommandBus\Commands;') !== false);
    }

    /**
     * Test Handler file is created
     */
    public function test_it_creates_handler()
    {
        $this->makeHandler();

        $this->assertTrue(file_exists($this->getExpectedHandlerFile()));
    }

    /**
     * Test DummyClass is replaced correctly in Handler
     */
    public function test_it_names_handler()
    {
        $this->makeHandler();
        $this->assertTrue(strpos(file_get_contents($this->getExpectedHandlerFile()), 'class FooHandler') !== false);
        $this->assertTrue(strpos(file_get_contents($this->getExpectedHandlerFile()), 'FooHandler constructor') !== false);
    }

    /**
     * Test DummyNamespace is replaced correctly in Handler
     */
    public function test_it_namespaces_handler()
    {
        $this->makeHandler();

        $this->assertTrue(strpos(file_get_contents($this->getExpectedHandlerFile()), 'namespace App\CommandBus\Handlers;') !== false);
    }

    /**
     * Test instance of Command is injected to Handler
     */
    public function test_it_adds_handler_to_command()
    {
        $this->makeHandler();
        dd(file_get_contents($this->getExpectedHandlerFile()));
        $this->assertTrue(strpos(file_get_contents($this->getExpectedHandlerFile()), '* @param FooCommand $command') !== false);
        $this->assertTrue(strpos(file_get_contents($this->getExpectedHandlerFile()), 'public function handle(FooCommand $command)') !== false);
    }
}
