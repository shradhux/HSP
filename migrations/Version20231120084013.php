<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120084013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8EC5A68DA76ED395 ON postuler (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP is_validated');
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68DA76ED395');
        $this->addSql('DROP INDEX IDX_8EC5A68DA76ED395 ON postuler');
        $this->addSql('ALTER TABLE postuler DROP user_id');
    }
}