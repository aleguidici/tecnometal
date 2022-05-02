<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\PresupuestoController;

class PresupuestoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     * @group Unit
     */

    public function testCreate_new_id()
    {
        $pres = new PresupuestoController();
        $id_obtained = $pres->create_new_id(2011111);
        $this->assertSame(2011112,$id_obtained);
    }
}
