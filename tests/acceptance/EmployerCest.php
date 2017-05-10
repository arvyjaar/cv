<?php


class EmployerCest
{
    public function signIn(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->waitForElement('#username', 20);
        $I->fillField('_username', 'microsoft@email.com');
        $I->fillField('_password', '123456');
        $I->click('Prisijunk');
        $I->waitForText('Veiksmai', 20);
        $I->see('Šiuo metu darbo ieško');
    }

    public function createNewJobAd(AcceptanceTester $I)
    {
        $this->signIn($I);
        $I->click('Veiksmai');
        $I->click('Sukurti naują skelbimą');
        $I->amOnPage('/skelbimai/naujas');
        $I->fillField('job_ad[title]', 'Frontend developer');
        $I->click('Pridėti reikalavimus');
        $I->fillField('requirement', 'React');
        $I->click('Pridėk');
        $I->click('x');
        $I->fillField('job_ad[assignment]', 'https://drive.google.com/drive/');
        $I->fillField('job_ad[description]', 'Perspektyvus darbas su puikiom perspektyvom.');
        $I->click('Sukurti');
        $I->waitForText('FRONTEND DEVELOPER', 20);
        $I->see('FRONTEND DEVELOPER');
    }
}
