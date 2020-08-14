<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200814183018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sorties_participants (sorties_id INT NOT NULL, participants_id INT NOT NULL, INDEX IDX_BB662DEC15DFCFB2 (sorties_id), INDEX IDX_BB662DEC838709D5 (participants_id), PRIMARY KEY(sorties_id, participants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC15DFCFB2 FOREIGN KEY (sorties_id) REFERENCES sorties (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorties_participants ADD CONSTRAINT FK_BB662DEC838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE inscriptions');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscriptions (id INT AUTO_INCREMENT NOT NULL, sortie_id INT NOT NULL, participant_id INT NOT NULL, date_inscription DATETIME NOT NULL, INDEX IDX_74E0281C9D1C3019 (participant_id), INDEX IDX_74E0281CCC72D953 (sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281C9D1C3019 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('ALTER TABLE inscriptions ADD CONSTRAINT FK_74E0281CCC72D953 FOREIGN KEY (sortie_id) REFERENCES sorties (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE sorties_participants');
    }
}
