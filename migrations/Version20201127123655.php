<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127123655 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_stats (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, num_views INTEGER NOT NULL, num_likes INTEGER NOT NULL, num_comments INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE project_thumbnail (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, src VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE projects (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thumbnail_id INTEGER DEFAULT NULL, stats_id INTEGER DEFAULT NULL, link VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, about_contents VARCHAR(255) NOT NULL, num_floors INTEGER NOT NULL, num_rooms INTEGER NOT NULL, num_other_items INTEGER NOT NULL, hits INTEGER DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A436AC99F1 ON projects (link)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4D1B862B8 ON projects (hash)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4FDFF2E92 ON projects (thumbnail_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A470AA3482 ON projects (stats_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE project_stats');
        $this->addSql('DROP TABLE project_thumbnail');
        $this->addSql('DROP TABLE projects');
    }
}
