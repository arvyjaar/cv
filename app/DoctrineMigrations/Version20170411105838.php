<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170411105838 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_seeker (id INT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, birthday DATE DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, profession VARCHAR(255) DEFAULT NULL, skills LONGTEXT DEFAULT NULL, introduction LONGTEXT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E60F91CEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_apply (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, cv VARCHAR(255) NOT NULL, jobAd_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_BC73316F456C5646 (evaluation_id), INDEX IDX_BC73316F541CFCC8 (jobAd_id), INDEX IDX_BC73316FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_employer (id INT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, sector VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3EC11466A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, mark INT NOT NULL, comment LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_ad (id INT AUTO_INCREMENT NOT NULL, employer_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, assignment VARCHAR(255) NOT NULL, requirements LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_C339C4A141CD9E7A (employer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_seeker ADD CONSTRAINT FK_E60F91CEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_seeker ADD CONSTRAINT FK_E60F91CEBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_apply ADD CONSTRAINT FK_BC73316F456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE job_apply ADD CONSTRAINT FK_BC73316F541CFCC8 FOREIGN KEY (jobAd_id) REFERENCES job_ad (id)');
        $this->addSql('ALTER TABLE job_apply ADD CONSTRAINT FK_BC73316FA76ED395 FOREIGN KEY (user_id) REFERENCES user_seeker (id)');
        $this->addSql('ALTER TABLE user_employer ADD CONSTRAINT FK_3EC11466A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_employer ADD CONSTRAINT FK_3EC11466BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_ad ADD CONSTRAINT FK_C339C4A141CD9E7A FOREIGN KEY (employer_id) REFERENCES user_employer (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_seeker DROP FOREIGN KEY FK_E60F91CEA76ED395');
        $this->addSql('ALTER TABLE user_seeker DROP FOREIGN KEY FK_E60F91CEBF396750');
        $this->addSql('ALTER TABLE user_employer DROP FOREIGN KEY FK_3EC11466A76ED395');
        $this->addSql('ALTER TABLE user_employer DROP FOREIGN KEY FK_3EC11466BF396750');
        $this->addSql('ALTER TABLE job_apply DROP FOREIGN KEY FK_BC73316FA76ED395');
        $this->addSql('ALTER TABLE job_ad DROP FOREIGN KEY FK_C339C4A141CD9E7A');
        $this->addSql('ALTER TABLE job_apply DROP FOREIGN KEY FK_BC73316F456C5646');
        $this->addSql('ALTER TABLE job_apply DROP FOREIGN KEY FK_BC73316F541CFCC8');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_seeker');
        $this->addSql('DROP TABLE job_apply');
        $this->addSql('DROP TABLE user_employer');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE job_ad');
    }
}
