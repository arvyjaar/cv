<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170410151830 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, mark INT NOT NULL, comment LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_ad (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, assignment VARCHAR(255) NOT NULL, requirements LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_apply ADD evaluation_id INT DEFAULT NULL, ADD jobAd_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_apply ADD CONSTRAINT FK_BC73316F456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE job_apply ADD CONSTRAINT FK_BC73316F541CFCC8 FOREIGN KEY (jobAd_id) REFERENCES job_ad (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BC73316F456C5646 ON job_apply (evaluation_id)');
        $this->addSql('CREATE INDEX IDX_BC73316F541CFCC8 ON job_apply (jobAd_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job_apply DROP FOREIGN KEY FK_BC73316F456C5646');
        $this->addSql('ALTER TABLE job_apply DROP FOREIGN KEY FK_BC73316F541CFCC8');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE job_ad');
        $this->addSql('DROP INDEX UNIQ_BC73316F456C5646 ON job_apply');
        $this->addSql('DROP INDEX IDX_BC73316F541CFCC8 ON job_apply');
        $this->addSql('ALTER TABLE job_apply DROP evaluation_id, DROP jobAd_id');
    }
}
