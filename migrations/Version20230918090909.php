<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918090909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference ADD amphitheatre_id INT NOT NULL');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C88388A4EA FOREIGN KEY (amphitheatre_id) REFERENCES amphitheatre (id)');
        $this->addSql('CREATE INDEX IDX_911533C88388A4EA ON conference (amphitheatre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C88388A4EA');
        $this->addSql('DROP INDEX IDX_911533C88388A4EA ON conference');
        $this->addSql('ALTER TABLE conference DROP amphitheatre_id');
    }
}
