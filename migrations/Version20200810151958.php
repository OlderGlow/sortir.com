<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810151958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campus (id INT AUTO_INCREMENT NOT NULL, nom_campus VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscriptions (id INT AUTO_INCREMENT NOT NULL, sortie_id INT NOT NULL, participant_id INT NOT NULL, date_inscription DATETIME NOT NULL, INDEX IDX_74E0281CCC72D953 (sortie_id), INDEX IDX_74E0281C9D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieux (id INT AUTO_INCREMENT NOT NULL, nom_lieu VARCHAR(30) NOT NULL, rue VARCHAR(30) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, Villes INT DEFAULT NULL, INDEX IDX_9E44A8AE1E8C9AEE (Villes), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participants (id INT AUTO_INCREMENT NOT NULL, campus INT DEFAULT NULL, pseudo VARCHAR(30) NOT NULL, nom VARCHAR(80) NOT NULL, prenom VARCHAR(80) NOT NULL, telephone VARCHAR(10) DEFAULT NULL, mail VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, roles JSON NOT NULL, actif TINYINT(1) NOT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_716970929D096811 (campus), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorties (id INT AUTO_INCREMENT NOT NULL, organisateur INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, datedebut DATETIME DEFAULT NULL, duree INT DEFAULT NULL, datecloture DATETIME DEFAULT NULL, nbinscriptionsmax INT NOT NULL, descriptioninfos VARCHAR(500) DEFAULT NULL, etat enum(\'En création\', \'En cours\', \'Ouvert\', \'Fermé\', \'Annulée\'), Lieux INT DEFAULT NULL, Campus INT DEFAULT NULL, INDEX IDX_488163E84BD76D44 (organisateur), INDEX IDX_488163E85F8587AA (Lieux), INDEX IDX_488163E89AA56D27 (Campus), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE villes (id INT AUTO_INCREMENT NOT NULL, nom_ville VARCHAR(30) NOT NULL, code_postal VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CCC72D953 FOREIGN KEY (sortie_id) REFERENCES sorties (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C9D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE lieux ADD CONSTRAINT FK_9E44A8AE1E8C9AEE FOREIGN KEY (Villes) REFERENCES villes (id)');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970929D096811 FOREIGN KEY (campus) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E84BD76D44 FOREIGN KEY (organisateur) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E85F8587AA FOREIGN KEY (Lieux) REFERENCES lieux (id)');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E89AA56D27 FOREIGN KEY (Campus) REFERENCES campus (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970929D096811');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E89AA56D27');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E85F8587AA');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281C9D1C3019');
        $this->addSql('ALTER TABLE sorties DROP FOREIGN KEY FK_488163E84BD76D44');
        $this->addSql('ALTER TABLE inscriptions DROP FOREIGN KEY FK_74E0281CCC72D953');
        $this->addSql('ALTER TABLE lieux DROP FOREIGN KEY FK_9E44A8AE1E8C9AEE');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE inscriptions');
        $this->addSql('DROP TABLE lieux');
        $this->addSql('DROP TABLE participants');
        $this->addSql('DROP TABLE sorties');
        $this->addSql('DROP TABLE villes');
    }
}
