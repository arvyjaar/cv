<?php

class SeekerCest
{
    public function signIn(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->waitForElement('#username', 20);
        $I->fillField('_username', 'jonas@email.com');
        $I->fillField('_password', '123456');
        $I->click('Prisijunk');
        $I->waitForText('Veiksmai', 20);
        $I->see('Darbo skelbimai');
    }

    public function register(AcceptanceTester $I)
    {
        $I->amOnPage('/registruotis/ieskau-darbo');
        $I->fillField('fos_user_registration_form[name]', 'Vardas');
        $I->fillField('fos_user_registration_form[surname]', 'Pavardenis');
        $I->fillField('fos_user_registration_form[email]', 'random@random.com');
        $I->fillField('fos_user_registration_form[plainPassword][first]', '123456');
        $I->fillField('fos_user_registration_form[plainPassword][second]', '123456');
        $I->click('Registruokis');
        $I->waitForText('Veiksmai', 20);
        $I->see('Darbo skelbimai');
    }

    public function applyForAJob(AcceptanceTester $I)
    {
        $this->signIn($I);
        $I->amOnPage('/skelbimai/1');
        $I->waitForElement('#submit-apply', 20);
        $I->click('#submit-apply');
        $I->fillField('job_apply[assignmentSolution]', 'https://drive.google.com/drive/');
        $I->click('Kandidatuoti');
        $I->waitForText('Darbo skelbimai', 20);
        $I->see('Darbo skelbimai');
    }
}
