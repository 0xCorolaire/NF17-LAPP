NF17 Tenta
===

## Module 2 - MCD avec l'UML

**Modèle** : représentation simplifiée de la réalité en vue de réaliser quelque chose, abstrait, orienté pour un usage

### Classes et Attributs

**Attribut** : information élémentaire qui caractérise une classe et dont la valeur dépend de l'objet instancié. Un attribut est :
- **typé** : domaine de valeurs fixé
- **multivalué** : peut prendre plusieurs valeurs
- **dérivé** : fonction d'autres attributs, UML $\to$ Méthode
- **composite** : groupe d'attributs, UML $\to$ Composition (ex: adresse)

```uml
attribut:type
attribut_multivalué[nbMinValeurs..nbMaxValeurs]:type
/attribut_dérivé:type
attribut_composé
- sous-attribut1:type
- sous-attribut2:type
```

![Exemple](https://stph.scenari-community.org/bdd/mod1/res/attrib1.jpg)

Repérage des clés :
```
clé:type {key}
{(subclé1, subclé2) key}
```
Pas de clé artificielle dans le MCD !



**Méthode :** `methode(paramètres):type`
Implémentées par des vues en SQL


## Module 3 - MLD


#### Clés
**Clé primaire :** `#clé` ou `#a, #b, #c`
**Clé candidate :** repérée à coté `avec (a,b,c) key`
**Clé signifiante/naturelle :** non artificielle
**Clé étrangère :** AttributN => Relation2.attr



*Clé artificielle seulement si utile pour raison de complexité, justifier !*
NB : Au niveau Physique (implémentation, étape 4) : artificielle plutôt que naturelle si
- évolutions futures : perte unicité
- maintenance : changement valeur
- performance : taille plus optimale

```
Personne (#Numero:Entier, Nom:Chaîne, Prénom:Chaîne, LieuNaissance=>Ville)
Pays (#Nom:Chaîne, Population:Entier, Superficie:Réel, Dirigeant=>Personne)
Région (#Pays=>Pays, #Nom:Chaîne, Superficie, Dirigeant=>Personne)
Ville (#CodePostal:CP, Nom:Chaîne, Pays=>Région.Pays, Région=>Région.Nom,
Dirigeant=>Personne)
```


## Module 4 - Passage du MCD au MLD

### Attributs
| Attribut                    | MCD (UML)                                | $\to$ MLD                                |
| --------------------------- | ---------------------------------------- | ---------------------------------------- |
| Attribut Composite          | ![](https://stph.scenari-community.org/bdd/rel2/res/03attc.png) | `Classe1(#a,b_b1,b_b2)`                  |
| Attribut Multivalué         | ![](https://stph.scenari-community.org/bdd/rel2/res/04attmv.png) | `Classe1(#a)` et `RB(#b,#a=>Classe1)` <br> ou bien `Classe1(#a,b1,b2,b3)` |
| Attribut Composé Multivalué | ![](https://stph.scenari-community.org/bdd/rel2/res/04attmvc.png) | `Classe1(#a)` et `RB(#b_b1,#b_b2,#a=>Classe1)` |
| Attribut dérivés            | ![](https://stph.scenari-community.org/bdd/rel2/res/05attd.png) | Pas représenté en MLD (niveau applicatif ou *triggers*) |

### Associations 

####Compositions


|               Composition                |                                MCD (UML) | $\to$ MLD            |                | ---------------------------------------: | ---------------------------------------: | -------------------- |
|               Composition                | ![](https://stph.scenari-community.org/bdd/rel2/res/13comp.png) | `Classe1(#a,b)` `Classe2(#c,#a=>Classe1,d)`<br>{local key} est la clé de de la composée |
| Composition et Attribut Composé Multivalué | ![](https://stph.scenari-community.org/bdd/rel2/res/13compAttmvc.png) | `Classe1(#a)` `RB(#b_b1,#b_b2,#a=>Classe1)` |
|    Composition et Attribut Multivalué    | ![](https://stph.scenari-community.org/bdd/rel2/res/13compAttmv.png) | `Classe1(#a)` `RB(#b,#a=>Classe1)`       |
- transformer comme une association 1:N,
- ajout de la clé de la classe partie (dite clé locale) la clé étrangère vers la classe composite pour construire une clé primaire composée (il faut le composant et sa clé en composant de clé)



#### Associations 
|              Association |                                MCD (UML) | $\to$ MLD                                |
| -----------------------: | ---------------------------------------: | ---------------------------------------- |
|                      1:N | ![](https://stph.scenari-community.org/bdd/rel2/res/06a0n.png) | `Classe1(#a,b)` `Classe2(#c,d,a=>Classe1)` |
|                      N:M | ![](https://stph.scenari-community.org/bdd/rel2/res/07anm0.png) | `Classe1(#a,b)` ,  `Classe2(#c,d)` `Assoc(#a=>Classe1,#c=>Classe2)` |
|                      1:1 | ![](https://stph.scenari-community.org/bdd/rel2/res/08a11.png) | `Classe1(#a,b,c=>Classe2) avec c UNIQUE` et `Classe2(#c,d)` ou inverse<br>Contrainte (éventuellement) : `Proj(Classe1,a)=Proj(Classe2,a)`<br>Ou bien : Fusion : `Classe12(#a,b,c,d) avec c KEY` ou `Classe21(#c,d,a,b) avec a KEY` |
|                1..1:1..1 | ![](https://stph.scenari-community.org/bdd/mod3/res/08a11.png) | Fusion (voire clé étrangère)             |
|                0..1:1..1 | ![](https://stph.scenari-community.org/bdd/mod3/res/09a01.png) | Clé étrangère <br>`Classe1(#a,b,c=>Classe2) avec c KEY` `Classe2(#c,d)` ou `Classe12(#c,d,a,b) avec a UNIQUE` |
|                0..1:0..1 | ![](https://stph.scenari-community.org/bdd/mod3/res/10a00.png) | Clé étrangère unique `Classe1(#a,b,c=>Classe2) avec c UNIQUE` `Classe2(#c,d)` ou inverse |
| Classe d'association N:M | ![](https://stph.scenari-community.org/bdd/rel2/res/11cla_ass20-nolocalkey.png) | `Classe1(#a,b)` , `Classe2(#c,d)` `Assoc(#a=>Classe1,#c=>Classe2,e,f)`<br>Peut avoir une `#g {local key}` en plus |
Classe d'association 1:N ou 1:1 : ajouter les attributs à une classe


## Module 5 - SQL

#### Types SQL
- Charactères :
  - `CHAR(x)` : (longueure fixe complétée avec espaces)
  - `VARCHAR(x)` : (longueure fixe)
- Nombres : 
  - `INTEGER`, `SMALLINT`, `BIT`
  - `FLOAT(x)` : valeur approchée
  - `REAL` = `FLOAT(24)` : double precision
  - `DECIMAL(x,y)` ou `NUMERIC(x,y)` : au plus x chiffres significatifs dont y décimales
- Date :
  - `DATE` (AAAA-MM-DD), `TIME`, `TIMESTAMP`, `DATETIME` (AAAA-MM-DD HH:MM:SS), `INTERVAL` (intervalle de date/temps)

#### Contraintes
`NOT NULL`, `PRIMARY KEY(..)`, `UNIQUE(...)`, `FOREIGN KEY (..) REFERENCES Tables(attribut)`
`CHECK(conditions...)`
Clé candidate : `UNIQUE AND NOT NULL`

#### Opérations
##### Language de Définition de Données

```sql
CREATE TABLE 'nom table' (
	attribut1 : type1 PRIMARY KEY, attribut2 : type2, ...,
	FOREIGN KEY (attribut3) REFERENCES table(attribut)
);
```
```sql
DROP type nom;
DROP TABLE 'table';
DROP VIEW 'vue';
```
```sql
ALTER TABLE 'table' ADD attribut type,
					DROP nom_attribut,
					MODIFY attribut nv_type;
```
```sql
CREATE TYPE nom_type AS OBJECT (
  nom_attribut1 type_attribut1,
  ...
);
```

##### Language de Manipulation de Données
```sql
INSERT INTO 'table' (attribut1, ...) VALUES ('chaine1', 10, ...);
```
```sql
UPDATE Table SET (attribut3="chaine4", attribut2=4) WHERE condition;
```
```sql
DELETE FROM Table WHERE condition;
```
```sql
SELECT DISTINCT Table.attr1 AS Attribut1, Table.attr2 FROM Table WHERE condition
	ORDER BY attr1, attr2 ASC/DESC;
```
```sql
SELECT CURRENT_DATE AS now; -- Constante
```
```sql
SELECT * FROM Table WHERE attr1 LIKE 'regex', attr2 IS NULL
	attr3 BETWEEN 1 AND 2, attr4 in ('A', 'B');
```
LIKE : `%` = 0 ou plusieurs charactères; `_` = 1 seul charactère

```sql
SELECT E1.Nom FROM Employe E1, Employe E2 WHERE E1.Nom= E2.Nom; -- Autojointure
```

```sql
SELECT * FROM (R1 INNER JOIN R2 ON <condition>) INNER JOIN R3 ON <condition>
```

##### Language de Contrôle de Données


PostgreSQL :
```postgresql
CREATE USER user1 WITH ENCRYPTED PASSWORD 'password';
```
```postgresql
CREATE DATABASE mydb WITH OWNER user1;
```

#### Exemple
```sql
CREATE TABLE Personne (
	N°SS CHAR(13) PRIMARY KEY,
	Nom VARCHAR(25) NOT NULL,
	Prenom VARCHAR(25) NOT NULL,
	Age INTEGER(3) CHECK (Age BETWEEN 18 AND 65),
	Mariage CHAR(13) REFERENCES Personne(N°SS),
	Codepostal INTEGER(5),
	Pays VARCHAR(50),
	UNIQUE (Nom, Prenom),
	FOREIGN KEY (Codepostal, Pays) REFERENCES Adresse (CP, Pays)
);
CREATE TABLE Adresse (
	CP INTEGER(5) NOT NULL,
	Pays VARCHAR(50) NOT NULL,
	Initiale CHAR(1) CHECK (Initiale = LEFT(Pays, 1)),
	PRIMARY KEY (CP, Pays)
);
```


## Module 6 - PostgreSQL

Connexion à un serveur PostgreSQL avec le client psql
`psql -h server.adress.or.ip -d database -U user`
`psql` = `psql -h localhost -d me -U me`

#### Commandes
- `\?` : Liste des commandes psql
- `\h` : Liste des instructions SQL
- `\h` CREATE TABLE : Description de l'instruction SQL CREATE TABLE
- `\d` : Liste des relations (catalogue de données)
- `\d` maTable : Description de la relation maTable
  Fondamenta l: Commandes de base : quitter
- `\q` : Quitter psql
- `\i /home/me/bdd.sql` : executer le fichier bdd.sql
- ` \copy nom_table(att1,...) FROM 'fichier.csv' WITH CSV DELIMITER ';' QUOTE '"'` : import CSV (table doit déjà exister)
- `\! pwd` : récupère le chemin courant
- `\cd directory`
- `\dn` : liste des schémas
- `\du` : liste des utilisateurs
- `\l` : liste des bases de données

#### Spécifique au PostgreSQL
Schémas
```postgresql
CREATE SCHEMA myschema;
SELECT FROM myschema.mytable
```
Schéma par défaut
```postgresql
SET search_path TO myschema,public;
```


## Module 7 - Algèbre Relationnel

#### Opérations fondamentaux
| Algèbre Relationnel                      | SQL                                      | Commentaire                      |
| ---------------------------------------- | ---------------------------------------- | -------------------------------- |
| Projection(Table, attr1, ...)            | SELECT attr1, ... FROM Table;            | Pas de doublons                  |
| Restriction(Table, Condition)            | SELECT * FROM Table WHERE Condition      |                                  |
| Produit(Table1, Table2)                  | SELECT * FROM Table1 JOIN Table2         | Donne N1 * N2 tuples             |
| Jointure(Table1, Table2, ConditionJointure) | SELECT * FROM Table1 INNER JOIN Table2 ON ConditionJointure; |                                  |
| JointureNaturelle                        | NATURAL JOIN                             | Jointure sur même nom de colonne |
| JointureExterne                          | OUTER JOIN                               | Condition + reste                |
| JointureGauche                           | LEFT OUTER JOIN                          | Condition + reste Table1         |
| JointureDroite                           | LEFT OUTER JOIN                          | Condition + reste Table2         |

#### Opérations ensemblistes
| Algèbre Relationnel          | SQL                                      | Commentaire                              |
| ---------------------------- | ---------------------------------------- | ---------------------------------------- |
| Union(Table1, Table2)        | SELECT * FROM R1 UNION SELECT * FROM R2  | Même schéma pour les tables              |
| Différence(Table1, Table2)   | SELECT * FROM R1 EXCEPT SELECT * FROM R2 | Même schéma pour les tables, tuples de T1 n'appartenant pas à T2 |
| Intersection(Table1, Table2) | SELECT * FROM R1 INTERSECT SELECT * FROM R2 | Même schéma pour les tables, tuples appartenant aussi à T1 et T2 |
| Division(Table1, Table2)     |                                          |                                          |
Division : Donnez toutes les personnes qui pratiquent tous les métiers de la relation métier

## Module 9 - Héritage et UML

### Héritage

association entre deux classes permettant d'exprimer que l'une est plus
générale que l'autre. L'héritage implique une transmission automatique des propriétés
(attributs et méthodes) d'une classe A à une classe A'.
A' hérite de A $\iff$ A' est une sous-classe de A $\iff$ A est une généralisation de A' $\iff$ A' est une spécialisation de A.

Avantages :
- factorisation
- permet de représenter la relation "est-un", deux classes filles peuvent être associées ensemble

![](https://stph.scenari-community.org/bdd/mod2/res/heritageFact.png)

**Classe Abstraite** : non instanciable, ne sert qu'à généraliser et à être héritée

![](https://stph.scenari-community.org/bdd/mod2/res/classeAbstraiteEx.jpg)

### Types d'héritage

**Héritage complet** : les classes filles n'ont aucun aucun attribut, ni méthode propres (sinon presque complet), et surtout aucune association propre.
![](https://stph.scenari-community.org/bdd/mod2/res/14h_c0.png)

**Héritage Exclusif** : les objets d'une classe fille ne peuvent appartenir aussi à une autre (noté {X} ou {XT} si mère abstraite) (à éviter)
![](https://stph.scenari-community.org/bdd/mod2/res/14h_x0.png)
(par défaut si pas de précision, exclusif)

**Héritage Multiple** : la classe fille hérite de plusieurs classes mères (à éviter)

### Équivalence entre héritage et association 1:1 (est-un)

![](https://stph.scenari-community.org/bdd/mod2/res/heritage-cardinalites.png)


## Module 10 - De l'héritage au relationnel

Modèle relationnel ne permet pas de représenter directement un héritage, puisque que seuls les concepts de relation et de clé existent dans le modèle. Il faut donc appauvrir le modèle conceptuel pour qu'il puisse être représenté selon un schéma relationnel.
Trois solutions existent pour transformer une relation d'héritage :
- Représenter l'héritage par une référence entre la classe mère et la classe fille.
- Représenter uniquement les classes filles par une relation chacune.
- Représenter uniquement la classe mère par une seule relation

### Transformation par référence

- Chaque classe, mère ou fille, est représentée par une relation.
- La clé primaire de la classe mère est utilisée pour identifier chacune de ses classes filles : cette clé étant pour chaque classe fille à la fois la clé primaire et une clé étrangère vers la classe mère.

![](https://stph.scenari-community.org/bdd/rel3/res/14h0.png)

`Classe1(#a,b)`
`Classe2(#a=>Classe1,c,d) avec c KEY`
`Classe3(#a=>Classe1,e,f) avec e KEY`


### Transformation par les classes filles

- Chaque classe fille est représentée par une relation, la classe mère n'est pas représentée (si elle est abstraite).
- Tous les attributs de la classe mère sont répétés au niveau de chaque classe fille.
- La clé primaire de la classe mère est utilisée pour identifier chacune de ses classes filles, celle de la fille n'est pas retenue.
- Adapté à l'héritage exclusif

![](https://stph.scenari-community.org/bdd/rel3/res/14h_a0.png)

`Classe2(#a,b,c,d) avec c KEY`
`Classe3(#a,b,e,f) avec e KEY`

### Transformation par la classe mère

- Classe mère représentée par une relation (pas ses classes filles).
- Tous les attributs de chaque classe fille sont réintégrés au niveau de la classe mère.
- La clé primaire de la classe mère est utilisée pour identifier la relation.
- Un attribut supplémentaire de discrimination t (pour "type"), est ajouté à la classe mère, afin de distinguer les tuples.
- Cet attribut est de type énumération et a pour valeurs possibles les noms de la classe mère ou des différents classes filles.
- Si une classe fille a une clé primaire propre, cette clé sera réintégrée à la classe mère, au même titre qu'un autre attribut, mais elle n'officiera pas en tant que clé candidate car elle pourra contenir des valeurs nulles (elle sera néanmoins unique).
- Adapté si classe mère non abstraite, héritage complet (sinon null pour certaines valeurs)

![](https://stph.scenari-community.org/bdd/rel3/res/14h0.png)

`Classe1(#a,b,c,d,e,f,t:{1,2,3}) avec c UNIQUE et e UNIQUE`

Vues :
`vClasse1 = Projection( Restriction(Classe1,t=1), a,b)`
`vClasse2 = Projection( Restriction(Classe1,t=2), a,b,c,d)`
`vClasse3 = Projection( Restriction(Classe1,t=3), a,b,e,f)`

Héritage non exclusif :
`Classe1(#a,b,c,d,e,f,t:{1,2,3,23})`

Par booléens :
`Classe1(#a,b,c,d,e,f,t2:boolean:,t3:boolean)`
Contraintes :
avec `t2 X t3` si l'héritage est exclusif
avec `t2 XOR t3` si l'héritage est exclusif et la classe mère abstraite

### Choix


|                        | Inconvénients                            | Cas d'usage                              |
| ---------------------- | ---------------------------------------- | ---------------------------------------- |
| Par référence          | Lourdeur liée à la nécessité de représenter les données des classes filles sur deux relations | Adapté à tous les cas, surtout classe mère non abstraite |
| Par les classes filles | Associations avec la classe mère peuvent être problématiques ; redondance dans le cas de l'héritage non exclusif | Adapté à l'héritage exclusif, particulièrement lorsque la classe mère est abstraite et ne comporte pas d'association |
| Par la classe mère     | Nullité systématique pour attributs filles (et pour classe mère non abstraite); héritage non exclusif et non complet problématique | Adapté à l'héritage (presque) complet, surtout classe mère non abstraite |

![](https://stph.scenari-community.org/bdd/rel3/res/choixHeritageUML2_1.png)

#### Cas simples
| Type d'héritage                          | Héritage par                 | Cas  | MLD                                      |
| ---------------------------------------- | ---------------------------- | ---- | ---------------------------------------- |
| Complet                                  | par classe mère              |      | Si classe mère abstraite :`Classe1(#a,b,t:{2,3})`<br>Si classe mère non abstraite : `Classe1(#a,b,t:{1,2,3})` |
| Presque complet                          | par classe mère              |      | `Classe1(#a,b,c,d,e,f,t:{1,2,3})` `Classe4(#g,h,fka=>Classe1)` |
| Non complet, mère abstraite, sans association | par classes filles           |      | `Classe2(#a,b,c,d) avec c KEY` `Classe3(#a,b,e,f) avec e KEY` |
| Non complet, mère non abstraite, sans association | par les classes filles       |      | `Classe1(#a,b)` `Classe2(#a,b,c,d) avec c KEY` `Classe3(#a,b,e,f,fka=>Classe2) avec e KEY` |
| Non exclusif                             | Tout sauf par classes filles |      |                                          |
| Multiple                                 | par référence                |      |                                          |

#### Cas complexes
Surtout regarder les associations, ce sont elles qui poseront le plus de problème un fois en relationnel (à cause de l'intégrité référentielle)

| Type d'héritage                          |                   Cas                    | MLD                                      | Remarque                                 |
| ---------------------------------------- | :--------------------------------------: | ---------------------------------------- | ---------------------------------------- |
| Héritage par les classes filles avec assoc M:N ou 1:N sur mère | ![](https://stph.scenari-community.org/bdd/rel3/res/14h_assoc.png) | `Classe2(#a,b,c,d) avec c KEY` <br>`Classe3(#a,b,e,f) avec e KEY` <br>`Classe4(#g,h,fka=>Classe2, fkb=>Classe3)` <br>Contrainte : `fka OR fkb` | ajouter autant de clés étrangères que de classes filles et  gérer le fait que ces clés ne peuvent pas être co-valuées |
| Héritage non complet par la classe mère (association M:N ou 1:N sur une classe fille) | ![](https://stph.scenari-community.org/bdd/rel3/res/14h_nc2.png) | `Classe1(#a,b,c,d,e,f,t:{1,2,3})` <br>`Classe4(#g,h,fka=>Classe1)` <br>Contraintes : `Classe4.fka ne référence que des enregistrements tels que Classe1.t=3` | limiter la portée de la clé étrangère de Classe4 |
| Héritage non complet par la classe mère (association entre classes filles) | ![](https://stph.scenari-community.org/bdd/rel3/res/14h_nc.png) | `Classe1(#a,b,c,d,e,f,fka=>Classe1,t:{1,2,3})` <br>Contraintes : fka ne référence que des enregistrements tels que t=2 ; si fka alors t=3 |                                          |


## Module 11 - Associations avancées en UML et en relationnel

### Composition

Possède les propriétés suivantes:
- associe une classe composite et des classes parties, tel que tout objet partie appartient à un et un seul objet composite. C'est donc une association 1:N.
- pas partageable, donc un objet partie ne peut appartenir qu'à un seul objet composite à la fois.
- le cycle de vie des objets parties est lié à celui de l'objet composite, donc un objet
  partie disparaît quand l'objet composite auquel il est associé disparaît.
- pas symétrique, une classe joue le rôle de conteneur pour les classes liées, elle prend donc un rôle particulier a priori.
- est une agrégation avec des contraintes supplémentaires (non partageabilité et cycle de vie lié).
- la cardinalité côté composite est toujours de exactement 1
- Un attribut composé et multivalué peut s'écrire avec une composition.

### Agrégation

- association particulière utilisée pour préciser une relation tout/partie (ou ensemble/élément), on parle d'association méréologique.
- simple terminologie
  ![](https://stph.scenari-community.org/bdd/mod3/res/agregation.png)

### Associations réflexives

Si non auto-réflexive :
- UML : contrainte par exemple {les personnes ne se marient pas avec elles-mêmes}
- relationnel : contrainte du type `AVEC pk ≠ fk`
- SQL : clause du type `CHECK pk != fk`


**Clé locale :** permet seulement de repérer l'object dans son contexte

### Associations ternaires

![](https://stph.scenari-community.org/bdd/mod3/res/ternaire.png)

### Vocabulaire 

##### Commun
- Clé (key)

##### Spécifique au MCD
- Clé locale (local key)

##### Spécifique au MLD
- Clé (key)
- Clé candidate (candidate key)
- Clé primaire (primary key)
- Clé alternative (alternate key)
- Clé artificielle (surrogate key)
- Clé naturelle (natural key, business key)
- Clé étrangère (foreign key)

### Transformation des compositions

Pour identifier une classe partie dans une composition, on utilise une clé locale concaténée à la clé étrangère vers la classe composite, afin d'exprimer la dépendance entre les deux classes.

Si une clé naturelle globale permet d'identifier de façon unique une partie indépendamment du tout, on préférera la conserver comme clé candidate plutôt que de la prendre pour clé primaire.

Si on la choisit comme clé primaire cela revient à avoir transformé la composition en agrégation, en redonnant une vie propre aux objets composants.

`Classe1(#a,b)`
`Classe2(#c,#a=>Classe1,d)`

Same as attribut composé multivalué

### Transformation des agrégations

De la même façon que les associations classiques

### Transformation des classes d'association avec clé locale

![](https://stph.scenari-community.org/bdd/mod3/res/11cla_ass20.png)
`Classe1(#a,b)`
`Classe2(#c,d)`
`Assoc(#a=>Classe1,#c=>Classe2,#e,f)`


### Récapitulatif

![](https://stph.scenari-community.org/bdd/mod3/res/tabcompUMLREL.png)

### Règles de l'UML

- Toutes les associations doivent être nommées (sauf composition, héritage,
  agrégation).
- Ne pas utiliser de nom générique pour les Classes comme "Entité", "Classe",
  "Objet", "Truc"...
- Éviter les noms génériques pour les associations (comme "est associé à")
- Attention au sens des compositions et agrégation, le losange est côté
  ensemble, et n'oubliez pas les cardinalités, notamment côté parties.
- N'utilisez pas le souligné ni les # en UML pour identifier les clés, préférez la contrainte {key}
- Préférez l'héritage aux booléens de typage en UML
- Les attributs dérivés sont réservés aux dérivations simples (des attributs de la même classe), si c'est plus complexe, préférez des méthodes (et dans le doute, précisez les modes de calcul sur le schéma ou dans une note à part)
- Donnez des exemples de contenu lorsque ce n'est pas évident (lorsque le couple nom d'attribut et type ne permet pas de façon évidente de comprendre de quoi l'on parle)
- Inutile de déclarer le type booléen en UML, utilisez-le directement comme un type de données connu
- Si tous vos héritages sont exclusifs, notez-le à part pour alléger votre schéma (et éviter l'abondance de XOR)



## Module 12 - Modélisation de données avancée avec le diagramme de classes UML


### Contraintes en UML

![](https://stph.scenari-community.org/bdd/mod4/res/contraintes.jpg)
![](https://stph.scenari-community.org/bdd/mod4/res/contraintesEx.jpg)

### Contraintes entre association
| Nom          | Description                              | Notation                | Exemple                                  |
| ------------ | ---------------------------------------- | ----------------------- | ---------------------------------------- |
| Inclusion    | Si l'assoc inclue est instanciée, l'autre doit l'être aussi | {I}, {Subset} ou {IN}   | ![](https://stph.scenari-community.org/bdd/mod4/res/contraintes-in.png) |
| Simultanéité | Assocs doivent être instanciées ensemble | {S}, {=} ou {AND}       | ![]()                                    |
| Exclusion    | Assocs ne peuvent pas être instanciées en même temps | {X}                     |                                          |
| Totalité     | au moins une des deux assocs doit être instanciée | {T} ou {OR}             | ![](https://stph.scenari-community.org/bdd/mod4/res/contraintes-or.png) |
| Partition    | Exactement une des deux assocs doit être instanciée | {XT}, {+}, {XOR} ou {P} |                                          |

### Contraintes de minimalité

|         Contrainte          |                 Exemple                  | MLD                                      |
| :-------------------------: | :--------------------------------------: | ---------------------------------------- |
|          Inclusion          | ![](https://stph.scenari-community.org/bdd/mod4/res/contraintes-or-ex.png) | `Personne (... loue=>Logement, possède=>Logement) avec (loue OR possède)` |
| Min 1 Association 0..1:1..N | ![](https://stph.scenari-community.org/bdd/mod4/res/06a1n.png) | `R1(#a,b)` `R2(#c,d,a=>R1)`              |
| Min 1 Association 1..N:1..M | ![](https://stph.scenari-community.org/bdd/mod4/res/07anm.png) | `R1(#a,b)` `R2(#c,d)` `A(#a=>R1,#c=>R2)` Contraintes : `PROJECTION(R1,a) = PROJECTION(A,a) AND PROJECTION(R2,c) = PROJECTION(A,c)` (une seule si 0..N) |

Si contrainte de minimalité : `Contraintes : Classe2.a NOT NULL` 
ou `Contraintes : a NOT NULL et PROJECTION(R1,a) = PROJECTION(R2,a)`

### Contraintes d'attribut
- {unique}
- {frozen} : une fois instancié, l'attribut ne peut plus changer
- {key}

### Éléments supplémentaires

#### Paquetage/Package
Permet d'organiser les classes et de faire des vues partielles
![](https://stph.scenari-community.org/bdd/mod4/res/package2.png)

#### Stéorotype
Permet d'ajouter de la sémantique aux classes en les typant, mécanique de méta-modélisation
![](https://stph.scenari-community.org/bdd/mod4/res/stereotype.png)

|               enumeration                |                 dataType                 |
| :--------------------------------------: | :--------------------------------------: |
| ![](https://stph.scenari-community.org/bdd/mod4/res/enumerationEx.png) | ![](https://stph.scenari-community.org/bdd/mod4/res/datatypeEx.png) |


### Conseils UML
- N'utilisez pas le souligné ni les # en UML pour identifier les clés, préférez la contrainte {key}
- Préférez l'héritage aux booléens de typage en UML
  **La projection élimine les doublons**

#### Clés artificielles
- en UML : on ne pose jamais de clés artificielles
- en relationnel : on pose rarement des clés artificielles sauf dans le cas de clés étrangères vraiment trop compliquées
- en SQL : on peut poser des clés artificielles si on a une bonne raison (ce n'est donc pas systématique, et c'est à justifier)



## Module 13 - Analyse de bases de données SQL avec les agrégats (GROUP BY)

**Agrégat** : partitionnement horizontal d'une table en sous-tables, en fonction des valeurs d'un ou plusieurs attributs de partitionnement, suivi éventuellement de l'application d'une fonction de calcul à chaque attribut

#### Group By
```sql
SELECT 'liste d\'attributs de partionnement à projeter et de fonctions de calcul'
FROM 'liste de relations'
WHERE 'condition à appliquer avant calcul de l\'agrégat'
GROUP BY 'liste ordonnée d\'attributs de partitionnement'
```

#### Fonctions d'agrégats
- `COUNT(Relation.Propriété)` : Renvoie le nombre de valeurs non nulles d'une propriété pour tous les tuples d'une relation ;
- `SUM(Relation.Propriété)` : Renvoie la somme des valeurs d'une propriété des tuples (numériques) d'une relation ;
- `AVG(Relation.Propriété)` : Renvoie la moyenne des valeurs d'une propriété des tuples (numériques) d'une relation ;
- `MIN(Relation.Propriété)` : Renvoie la plus petite valeur d'une propriété parmi les tuples d'une relation .
- `MAX(Relation.Propriété)` : Renvoie la plus grande valeur d'une propriété parmi les tuples d'une relation.
  Renvoie un seul tuple si non groupé

Attention :
Toute colonne de la clause GROUP BY doit désigner une colonne présente dans la
clause SELECT :
- soit comme attribut d'agrégation,
- soit comme attribut présent dans une fonction d'agrégation.

Requête légale :
```sql
SELECT ci.countrycode, co.name, count(*)
FROM city ci JOIN country co
ON ci.countrycode=co.countrycode
GROUP BY ci.countrycode, co.name;
```


#### Having :
Permet de faire une restriction sur l'agrégation
```sql
SELECT Societe.Nom, AVG(Personne.Age)
FROM Personne, Societe
WHERE Personne.NomSoc = Societe.Nom
GROUP BY Societe.Nom
HAVING COUNT(Personne.NumSS) > 2
```


#### Ordre des requêtes :
FROM -> WHERE -> GROUP BY -> HAVING -> SELECT -> ORDER BY 


## Module 14 - Vues et gestion des droits

#### Vues

But des vues masquer la complexité et assurer la sécurité

**Schéma externe** : sous-ensemble du schéma intégral, destiné à une utilisation spécifique de la base de données.

**Vue :** définition logique d'une relation, sans stockage de données, obtenue par interrogation d'une ou plusieurs tables de la BDD

```sql
CREATE VIEW Employe (Id, Nom)
AS
	SELECT N°SS, Nom
	FROM Personne
```

`WITH CHECK OPTION` si écriture possible

#### Héritage

##### Par filles
mère : `vClasse1=Union(Projection(Classe2,a,b),Projection(Classe3,a,b))`

##### Par mère :
filles :
`vClasse2=jointure(Classe1,Classe2,a=a)`
`vClasse3=jointure(Classe1,Classe3,a=a)`

`vClasse1=projection(restriction(Classe1,t=1),a,b)`
`vClasse2=projection(restriction(Classe1,t=2),a,b,c,d)`
`vClasse3=projection(restriction(Classe1,t=3),a,b,e,f)`



#### Gestion des droits

```sql
GRANT SELECT, UPDATE ON Personne TO Pierre WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON Adresse TO PUBLIC;
```

`WITH GRANT OPTION` est optionnelle, il permet de préciser que l'utilisateur a le droit de transférer ses propres droits sur la table à d'autres utilisateurs

Révocation des droits :
```sql
REVOKE SELECT, UPDATE, GRANT OPTION ON Personne FROM Pierre;
REVOKE ALL PRIVILEGES ON Adresse FROM PUBLIC;
```
En cascade

Création utilisateur :
```sql
CREATE USER
```


## Module 15 - Théorie de la normalisation relationnelle

## Définitions

**Dépendance fonctionnelle :** X et Y ss-ens d'attributs de R : X $\to$ Y si en connaissant X on connait Y

**Dépendance Fonctionnelle Élémentaire (DFE)** : attribut atomique (à droite)
Soit G un groupe d'attributs et A un attribut, une DF G→A est élémentaire si A n'est pas incluse dans G et s'il n'existe pas d'attribut A' de G qui détermine A



**Fermeture transitive F+ :** ensemble F de DFE, l'ensemble de toutes les DFE qui peuvent être composées par transitivité à partir des DFE de F. 

**Couverture minimale des DFE :**  ensemble de DFE est un sous-ensemble minimum des DFE permettant de générer toutes les autres DFE.

**Clé** : Soient une relation R(A1,A2,...,An) et K un sous-ensemble de A1,A2,... ,An. K est une clé de R si et seulement si :
1. K $\to$ A1,A2,...,An ie détermine toutes les clés

2. et il n'existe pas X inclus dans K tel que X $\to$ A1,A2,...,An.

ie : Ensemble minimum d'attributs d'une relation qui détermine tous les autres



**DF élémentaire : **Pour A → B, il n'existe pas de C tel quel C → B.
**DF simple : **A → B avec B composé d'un seul attribut.
**DF directe : **Pour A → B, il n'existe pas de C tel que A → C et C → B





Exemple :

(H,E) est une clé potentielle car elle dérive tous les autres attributs
(H,E) est unique car attr n'apparaissent pas en partie droite, + clé => la seule (critère de minimalité)



| Axiomes de Armstrong (1974) | Opération                                |
| --------------------------- | ---------------------------------------- |
| Réflexivité                 | Y $\in$ X $\implies$ X $\to$ Y           |
| Augmentation                | X $\to$ Y $\implies$ $\forall$ Z X, Z$\to$ Y, Z |
| Transitivité                | X $\to$ Y et Y $\to$  Z $\implies$ X $\to$ Z |
| Union                       | X $\to$ Y et X $\to$ Z $\implies$ X $\to$ Y, Z |
| Pseudo-transitivité         | X $\to$ Y et W $\to$ Y $\implies$ X, W $\to$  Z |
| Décomposition               | X $\to$ Y et Z $\in$ Y $\implies$ X $\to$ Z |

Décomposition préserve les DF si F+ reste la même



### Formes Normales

![](https://github.com/oceanedbs/NA17-Fiches/blob/master/NF.png?raw=true)

##### 1NF
- possède au moins une clé
- attributs **atomiques**

##### 2NF
permet d'éliminer les dépendances entre des parties de clé et des attributs n'appartenant pas à une clé.
- 1NF
- Un attribut non clé ne dépend pas d'une partie de la clé  (**pas subK => nK)** ie toutes les DF issues d'une clé sont élémentaires (**A => nK élémentaire**).

!! Pour toutes clés candidates !!

##### 3NF
permet d'éliminer les dépendances entre les attributs n'appartenant pas à une clé
- 2NF
- Un attribut non clé ne dépend pas d'un ou plusieurs attributs ne participant pas à la clé (**pas de nK => nK**) ie toutes les DFE vers des attributs n'appartenant pas à une clé, sont issues d'une clé (**K => nK**)

##### BCNF
permet d'éliminer les dépendances entre les attributs n'appartenant pas à une clé vers les parties de clé
Ne préservent pas toujours les DF !!
- 3 NF
- tout attribut qui n'appartient pas à une clé n'est pas source d'une DF vers une partie d'une clé (**pas de nK => subK**); ie les seules DFE existantes sont celles dans lesquelles une clé détermine un attribut (**K => Attr**) .


## Module 16 -  Conception de bases de données normalisées

### Décompositions

1FN = La clé. 2FN = Toute la clé. 3FN = Rien que la clé.
> The key, the whole key, nothing but the key

#### 0NF -> 1NF
`R(#pk,a,b,...)` avec a non atomique se décompose en :
`R1(#pk,b,...)`
`R2(#pk=>R1,#a)`

#### 1NF -> 2NF
Pour les NF supérieures à 1, afin de normaliser une relation R on réalise une décomposition en R1 et R2 pour chaque DFE responsable d'un défaut de normalisation tel que :
- la partie gauche de la DFE :
   a. devient la clé primaire de R2
    b. devient une clé étrangère de R1 vers R2
- la partie droite de la DFE
   a. est enlevée de R1
    b. est ajoutée comme attributs simples de R2

`R(#pk,k1,k1',a,b,c,...)` avec (k1,K1') clé et `k1'→ a,b` se décompose en :
`R1(#pk,k1,k1'=> R2,c,...)`
`R2(#k1',a,b)`

On peut parfois remplacer un attribut par une méthode, à faire.

#### 2NF -> 3NF
Soit R une relation comportant une DFE de a vers b qui n'appartiennent pas à une clé, alors R est décomposée en R1 et R2, tel que :
R1 est R moins les attributs déterminés par a et avec a clé étrangère vers R2
R2 est composée de a et des attributs qu'elle détermine, avec a clé primaire de R2

`R(#pk,a,b,c,...)` avec a→b se décompose en
`R1(#pk,a=>R2,c,...)`
`R2(#a,b)`

### Étape de la conception d'une Base de Données
1. Analyse et clarification du problème posé
2. Modélisation conceptuelle en UML
  Résultat : MCD1
3. Traduction en relationnel en utilisant les règles de passage UML vers relationnel
  Résultat : MLD1
4. Établissement des DF sous la forme de la fermeture transitive pour chaque relation du
  modèle
  Résultat : MLD1 avec F+
5. Établissement de la forme normale
  Résultat : MLD1 avec F+ et NF
6. Décomposition des relations jusqu'à arriver en 3NF en préservant les DF
  Résultat : MLD2 avec F+ et 3NF
7. Rétro-conception du modèle UML correspondant
  Résultat : MCD2
8. Implémentation en SQL du modèle MLD2
