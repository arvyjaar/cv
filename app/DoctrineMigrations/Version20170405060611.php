<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170405060611 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cv DROP name, DROP surname, DROP email, DROP phone, DROP dateOfBirth, DROP photo');
        $this->addSql('ALTER TABLE evaluation CHANGE comment comment LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_ad CHANGE description description LONGTEXT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cv ADD name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD surname VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD phone VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, ADD dateOfBirth DATE NOT NULL, ADD photo VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE evaluation CHANGE comment comment VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE job_ad CHANGE description description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
