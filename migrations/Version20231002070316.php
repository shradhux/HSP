<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002070316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conference ADD ref_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_911533C8637A8045 ON conference (ref_user_id)');
        $this->addSql('ALTER TABLE creation ADD ref_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE creation ADD CONSTRAINT FK_57EE8574637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_57EE8574637A8045 ON creation (ref_user_id)');
        $this->addSql('ALTER TABLE offre_emploi ADD ref_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D1637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_132AD0D1637A8045 ON offre_emploi (ref_user_id)');
        $this->addSql('ALTER TABLE rendez_vous ADD ref_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A637A8045 ON rendez_vous (ref_user_id)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE validation ADD ref_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E637A8045 FOREIGN KEY (ref_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_16AC5B6E637A8045 ON validation (ref_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8637A8045');
        $this->addSql('DROP INDEX IDX_911533C8637A8045 ON conference');
        $this->addSql('ALTER TABLE conference DROP ref_user_id');
        $this->addSql('ALTER TABLE creation DROP FOREIGN KEY FK_57EE8574637A8045');
        $this->addSql('DROP INDEX IDX_57EE8574637A8045 ON creation');
        $this->addSql('ALTER TABLE creation DROP ref_user_id');
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D1637A8045');
        $this->addSql('DROP INDEX IDX_132AD0D1637A8045 ON offre_emploi');
        $this->addSql('ALTER TABLE offre_emploi DROP ref_user_id');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A637A8045');
        $this->addSql('DROP INDEX IDX_65E8AA0A637A8045 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP ref_user_id');
        $this->addSql('ALTER TABLE user DROP is_verified');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E637A8045');
        $this->addSql('DROP INDEX IDX_16AC5B6E637A8045 ON validation');
        $this->addSql('ALTER TABLE validation DROP ref_user_id');
    }
}
