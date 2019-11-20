<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120165809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE crossword (id INT AUTO_INCREMENT NOT NULL, words_id INT DEFAULT NULL, lvl INT NOT NULL, width INT NOT NULL, height INT NOT NULL, INDEX IDX_C11D4C53749B15FB (words_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE crossword_word (id INT AUTO_INCREMENT NOT NULL, word_name VARCHAR(255) NOT NULL, word_cells LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crossword ADD CONSTRAINT FK_C11D4C53749B15FB FOREIGN KEY (words_id) REFERENCES crossword_word (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE crossword DROP FOREIGN KEY FK_C11D4C53749B15FB');
        $this->addSql('DROP TABLE crossword');
        $this->addSql('DROP TABLE crossword_word');
    }
}
