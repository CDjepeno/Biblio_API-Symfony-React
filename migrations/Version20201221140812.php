<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221140812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_member (role_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_DBC21BC9D60322AC (role_id), INDEX IDX_DBC21BC97597D3FE (member_id), PRIMARY KEY(role_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_member ADD CONSTRAINT FK_DBC21BC9D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_member ADD CONSTRAINT FK_DBC21BC97597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6ABD01F5ED');
        $this->addSql('DROP INDEX IDX_57698A6ABD01F5ED ON role');
        $this->addSql('ALTER TABLE role DROP members_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE role_member');
        $this->addSql('ALTER TABLE role ADD members_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6ABD01F5ED FOREIGN KEY (members_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_57698A6ABD01F5ED ON role (members_id)');
    }
}
