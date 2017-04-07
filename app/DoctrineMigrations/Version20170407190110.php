<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170407190110 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_seeker ADD name VARCHAR(255) NOT NULL, ADD surname VARCHAR(255) NOT NULL, ADD birthday DATE DEFAULT NULL, ADD photo VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD role VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_employer ADD title VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD role VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_employer DROP title, DROP description, DROP role');
        $this->addSql('ALTER TABLE user_seeker DROP name, DROP surname, DROP birthday, DROP photo, DROP phone, DROP city, DROP role');
    }
}
