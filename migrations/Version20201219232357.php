<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201219232357 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_rent (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, member_id INT DEFAULT NULL, date_rent DATETIME NOT NULL, date_return DATETIME NOT NULL, date_real_return DATETIME DEFAULT NULL, INDEX IDX_1BE506C416A2B381 (book_id), INDEX IDX_1BE506C47597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, commune_code VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_rent ADD CONSTRAINT FK_1BE506C416A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_rent ADD CONSTRAINT FK_1BE506C47597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_rent DROP FOREIGN KEY FK_1BE506C47597D3FE');
        $this->addSql('DROP TABLE book_rent');
        $this->addSql('DROP TABLE member');
    }
}
