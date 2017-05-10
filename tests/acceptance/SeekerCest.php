<?php

class SeekerCest
{
    public function signIn(AcceptanceTester $I)
    {
        $I->amOnPage('/prisijungti');
        $I->fillField('_username', 'jonas@email.com');
        $I->fillField('_password', '123456');
        $I->click('Prisijunk');
        $I->waitForText('Veiksmai', 3);
        $I->see('Darbo skelbimai');
    }

    public function register(AcceptanceTester $I)
    {
        $I->amOnPage('/registruotis/ieskau-darbo');
        $I->fillField('fos_user_registration_form[name]', 'Vardas');
        $I->fillField('fos_user_registration_form[surname]', 'Pavardenis');
        $I->fillField('fos_user_registration_form[email]', $this->generateRandomEmail());
        $I->fillField('fos_user_registration_form[plainPassword][first]', '123456');
        $I->fillField('fos_user_registration_form[plainPassword][second]', '123456');
        $I->click('Registruokis');
        $I->waitForText('Veiksmai', 3);
        $I->see('Darbo skelbimai');
    }

    public function applyForAJob(AcceptanceTester $I)
    {
        $this->register($I);
        $I->click('Rodyti daugiau');
        $I->click('Kandidatuoti');
        $I->fillField('job_apply[assignmentSolution]', 'https://drive.google.com/drive/');
        $I->click('Kandidatuoti');
        $I->waitForText('Darbo skelbimai', 3);
        $I->see('Darbo skelbimai');
    }

    public function generateRandomEmail()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString . '@email.com';
    }
}
