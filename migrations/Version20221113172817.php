<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221113172817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE color DROP FOREIGN KEY FK_665648E960E4B879');
        $this->addSql('DROP INDEX IDX_665648E960E4B879 ON color');
        $this->addSql('ALTER TABLE color CHANGE feature_id features_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE color ADD CONSTRAINT FK_665648E9CEC89005 FOREIGN KEY (features_id) REFERENCES `feature` (id)');
        $this->addSql('CREATE INDEX IDX_665648E9CEC89005 ON color (features_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `color` DROP FOREIGN KEY FK_665648E9CEC89005');
        $this->addSql('DROP INDEX IDX_665648E9CEC89005 ON `color`');
        $this->addSql('ALTER TABLE `color` CHANGE features_id feature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `color` ADD CONSTRAINT FK_665648E960E4B879 FOREIGN KEY (feature_id) REFERENCES feature (id)');
        $this->addSql('CREATE INDEX IDX_665648E960E4B879 ON `color` (feature_id)');
    }
}
