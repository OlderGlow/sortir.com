<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200811184816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E89AA56D27');
        $this->addSql('ALTER TABLE sorties CHANGE etat etat enum(\'En création\', \'En cours\', \'Ouvert\', \'Fermé\', \'Annulée\')');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E89AA56D27 FOREIGN KEY (Campus) REFERENCES campus (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E89AA56D27');
        $this->addSql('ALTER TABLE sorties CHANGE etat etat VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E89AA56D27 FOREIGN KEY (Campus) REFERENCES campus (id) ON DELETE CASCADE');
    }
}
