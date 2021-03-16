 	<?php 

class WelcomeCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function testIndexPage(AcceptanceTester $I)
    {
    	$I->amOnPage('/');
        $I->see('Belajar Coding From Zero to Hero');
    }
}
