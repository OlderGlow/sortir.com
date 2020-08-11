<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200811184527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CCC72D953');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CCC72D953 FOREIGN KEY (sortie_id) REFERENCES sorties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorties CHANGE etat etat enum(\'En création\', \'En cours\', \'Ouvert\', \'Fermé\', \'Annulée\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CCC72D953');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CCC72D953 FOREIGN KEY (sortie_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE sorties CHANGE etat etat VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
