<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120100742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler CHANGE rendez_vous_id rendez_vous_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous CHANGE ref_user_id ref_user_id INT DEFAULT NULL, CHANGE date date DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler CHANGE rendez_vous_id rendez_vous_id INT NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous CHANGE ref_user_id ref_user_id INT NOT NULL, CHANGE date date DATE NOT NULL');
    }
}
