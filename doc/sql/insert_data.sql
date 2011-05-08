INSERT INTO artist (name, sortname, homepage, annotation)
    VALUES ('Artist 1', 'Artist 1', 'http://artist1.com', 'aöfjfkfjkfk');
INSERT INTO artist (name, sortname, homepage, annotation)
    VALUES ('Artist 2', 'Artist 2', 'http://artist2.com', 'rjlökfjöldlkj');
INSERT INTO artist (name, sortname, homepage, annotation)
    VALUES ('Foo Bar', 'Bar, Foo', 'http://asdf.com', 'requiöasfjköfk');

INSERT INTO label (name, homepage, annotation)
    VALUES ('Label 1', 'http://label1.com', 'asjadfkaöfkakl');

INSERT INTO record (
    artist,
    title,
    box_set,
    type,
    first_year,
    this_year,
    format,
    packaging,
    lent
) VALUES (
    1,
    'Album 1',
    TRUE,
    'Album',
    2000,
    2002,
    'CD',
    'Jewel case',
    FALSE
), (
    2,
    'Album 1',
    TRUE,
    'Single',
    2000,
    2002,
    'CD',
    'Jewel case',
    FALSE
);

INSERT INTO list (name, public, "default")
    VALUES ('Shopping list', FALSE, FALSE);
INSERT INTO record_list (record, list) VALUES (1, 'Collection');
INSERT INTO record_list (record, list) VALUES (2, 'Collection');
