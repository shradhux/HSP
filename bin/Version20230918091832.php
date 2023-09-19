<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918091832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler ADD rendez_vous_id INT NOT NULL, ADD offre_emploi_id INT NOT NULL');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68D91EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68DB08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8EC5A68D91EF7EAA ON postuler (rendez_vous_id)');
        $this->addSql('CREATE INDEX IDX_8EC5A68DB08996ED ON postuler (offre_emploi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68D91EF7EAA');
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68DB08996ED');
        $this->addSql('DROP INDEX UNIQ_8EC5A68D91EF7EAA ON postuler');
        $this->addSql('DROP INDEX IDX_8EC5A68DB08996ED ON postuler');
        $this->addSql('ALTER TABLE postuler DROP rendez_vous_id, DROP offre_emploi_id');
    }
}
