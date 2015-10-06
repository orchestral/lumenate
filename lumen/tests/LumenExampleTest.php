<?php

class LumenExampleTest extends LumenTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Lumen.');
    }
}
