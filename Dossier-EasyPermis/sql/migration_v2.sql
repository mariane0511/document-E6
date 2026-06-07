-- ============================================================
-- MIGRATION MAY-IT v2 — Modifications Avril 2026
-- ============================================================

-- 1. Ajouter la colonne statut à la table lecon
--    Valeurs possibles : 'planifiee' (défaut), 'annulee', 'terminee'
ALTER TABLE lecon
    ADD COLUMN IF NOT EXISTS statut VARCHAR(20) DEFAULT 'planifiee'
        COMMENT 'Statut de la leçon : planifiee | annulee | terminee';

-- Si votre MySQL ne supporte pas IF NOT EXISTS pour ALTER TABLE :
-- ALTER TABLE lecon ADD COLUMN statut VARCHAR(20) DEFAULT 'planifiee';

-- 2. Mettre à jour les leçons existantes déjà passées
UPDATE lecon
SET statut = 'terminee'
WHERE datefin < NOW() AND statut = 'planifiee';

-- 3. (Optionnel) Index sur statut pour les requêtes filtrées
CREATE INDEX IF NOT EXISTS idx_lecon_statut ON lecon(statut);

-- ============================================================
-- FIN DE MIGRATION
-- ============================================================
