<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127084614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE amphitheatre (id INT AUTO_INCREMENT NOT NULL, place_libre INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conference (id INT AUTO_INCREMENT NOT NULL, amphitheatre_id INT NOT NULL, ref_user_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_validated TINYINT(1) NOT NULL, date DATE NOT NULL, heure INT NOT NULL, duree INT NOT NULL, INDEX IDX_911533C88388A4EA (amphitheatre_id), INDEX IDX_911533C8637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creation (id INT AUTO_INCREMENT NOT NULL, conference_id INT NOT NULL, ref_user_id INT NOT NULL, INDEX IDX_57EE8574604B8382 (conference_id), INDEX IDX_57EE8574637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_emploi (id INT AUTO_INCREMENT NOT NULL, ref_user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type_contrat VARCHAR(255) NOT NULL, INDEX IDX_132AD0D1637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postuler (id INT AUTO_INCREMENT NOT NULL, rendez_vous_id INT DEFAULT NULL, offre_emploi_id INT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8EC5A68D91EF7EAA (rendez_vous_id), INDEX IDX_8EC5A68DB08996ED (offre_emploi_id), INDEX IDX_8EC5A68DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, ref_user_id INT DEFAULT NULL, date DATE DEFAULT NULL, heure INT DEFAULT NULL, INDEX IDX_65E8AA0A637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, domaine_etude VARCHAR(255) DEFAULT NULL, est_valide TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, rue VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, role VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE validation (id INT AUTO_INCREMENT NOT NULL, ref_user_id INT NOT NULL, INDEX IDX_16AC5B6E637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C88388A4EA FOREIGN KEY (amphitheatre_id) REFERENCES amphitheatre (id)');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE creation ADD CONSTRAINT FK_57EE8574604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id)');
        $this->addSql('ALTER TABLE creation ADD CONSTRAINT FK_57EE8574637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D1637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68D91EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68DB08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C88388A4EA');
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8637A8045');
        $this->addSql('ALTER TABLE creation DROP FOREIGN KEY FK_57EE8574604B8382');
        $this->addSql('ALTER TABLE creation DROP FOREIGN KEY FK_57EE8574637A8045');
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D1637A8045');
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68D91EF7EAA');
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68DB08996ED');
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68DA76ED395');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A637A8045');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E637A8045');
        $this->addSql('DROP TABLE amphitheatre');
        $this->addSql('DROP TABLE conference');
        $this->addSql('DROP TABLE creation');
        $this->addSql('DROP TABLE offre_emploi');
        $this->addSql('DROP TABLE postuler');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE validation');
    }
}
