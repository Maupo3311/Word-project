<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191125070714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE crossword_word (id INT AUTO_INCREMENT NOT NULL, crossword_id INT DEFAULT NULL, word_name VARCHAR(255) NOT NULL, word_cells LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_F6BA81B8377139C8 (crossword_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crossword (id INT AUTO_INCREMENT NOT NULL, lvl INT NOT NULL, width INT NOT NULL, height INT NOT NULL, chars VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crossword_word ADD CONSTRAINT FK_F6BA81B8377139C8 FOREIGN KEY (crossword_id) REFERENCES crossword (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE crossword_word DROP FOREIGN KEY FK_F6BA81B8377139C8');
        $this->addSql('DROP TABLE crossword_word');
        $this->addSql('DROP TABLE crossword');
    }
}
