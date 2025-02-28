<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813100700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etats (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sorties ADD etats_id INT DEFAULT NULL, DROP etat');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8CA7E0C2E FOREIGN KEY (etats_id) REFERENCES etats (id)');
        $this->addSql('CREATE INDEX IDX_488163E8CA7E0C2E ON sorties (etats_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E8CA7E0C2E');
        $this->addSql('DROP TABLE etats');
        $this->addSql('DROP INDEX IDX_488163E8CA7E0C2E ON sorties');
        $this->addSql('ALTER TABLE sorties ADD etat VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP etats_id');
    }
}
