use mitologiaslaravel;

SELECT m.id AS mitologia_id,
       m.titulo,
       m.Historia,
       c.id AS civilizacion_id,
       c.civilizacion AS civilizacion_nombre
FROM mitologias m
JOIN civilizaciones c
  ON m.civilizacion_id = c.id
WHERE m.id = 9;  -- aquí pones el ID de la mitología que quieras
