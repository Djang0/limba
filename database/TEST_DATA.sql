INSERT INTO TYPE_DOCUMENT (LABEL,AVAILABLE) VALUES ("Test",true);

INSERT INTO DOCUMENTS (PARENT_CAT_ID,TYPE_DOCUMENT,PERM_BIN,OWNER_ID,GROUP_ID,`POSITION`,`CREATED`,`UPDATED`) VALUES (4,1,'111111111000',2,2,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);
INSERT INTO DOCUMENT_INFO (DOC_ID ,LNG_ID , LABEL, TOOLTIP) VALUES (1 , (select id from LANGUES where ISO="fr"), "Document de teste", "Ceci est un document de teste");
INSERT INTO DOCUMENT_INFO (DOC_ID ,LNG_ID , LABEL, TOOLTIP) VALUES (1 , (select id from LANGUES where ISO="nl"), "Test document", "Dit is een test document");
INSERT INTO DOCUMENT_INFO (DOC_ID ,LNG_ID , LABEL, TOOLTIP) VALUES (1 , (select id from LANGUES where ISO="de"), "Test-Dokument", "Dies ist ein Test-Dokument");
INSERT INTO DOCUMENT_INFO (DOC_ID ,LNG_ID , LABEL, TOOLTIP) VALUES (1 , (select id from LANGUES where ISO="en"), "Test document", "This is a test document");

INSERT INTO PROPERTY (TYPE_DOCUMENT, TYPE_PROPERTY_ID,CSS_CLASS,CSS_ID) VALUES(1,1,'borderpanel',null);
INSERT INTO PROPERTY (TYPE_DOCUMENT, TYPE_PROPERTY_ID,PARENT_PROP,CSS_CLASS,CSS_ID) VALUES(1,2,1,'nom',null);
INSERT INTO PROPERTY (TYPE_DOCUMENT, TYPE_PROPERTY_ID,PARENT_PROP,CSS_CLASS,CSS_ID) VALUES(1,3,1,'txt',null);
INSERT INTO PROPERTY (TYPE_DOCUMENT, TYPE_PROPERTY_ID,PARENT_PROP,CSS_CLASS,CSS_ID) VALUES(1,4,1,'html','htmlsample');
INSERT INTO PROPERTY (TYPE_DOCUMENT, TYPE_PROPERTY_ID,PARENT_PROP,CSS_CLASS,CSS_ID) VALUES(1,5,1,'checkbox',null);
INSERT INTO PROPERTY (TYPE_DOCUMENT, TYPE_PROPERTY_ID,PARENT_PROP,CSS_CLASS,CSS_ID) VALUES(1,6,1,'Date',null);
INSERT INTO PROPERTY (TYPE_DOCUMENT, TYPE_PROPERTY_ID,PARENT_PROP,CSS_CLASS,CSS_ID) VALUES(1,7,1,'interval',null);

INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(1, (select id from LANGUES where ISO="fr"), "Panel", "Un Panel");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(1, (select id from LANGUES where ISO="nl"), "Paneel", "Een Paneel");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(1, (select id from LANGUES where ISO="de"), "Panel", "Eine Panel");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(1, (select id from LANGUES where ISO="en"), "Panel", "A Panel");


INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(2, (select id from LANGUES where ISO="fr"), "Nom", "une chaine de charactères représentant le nom");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(2, (select id from LANGUES where ISO="nl"), "Naam", "een tekenreeks die de naam");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(2, (select id from LANGUES where ISO="de"), "Namen", "eine Zeichenfolge, die den Namen");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(2, (select id from LANGUES where ISO="en"), "Name", "a string representing the name");

INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(3, (select id from LANGUES where ISO="fr"), "Text Fr", "Text tooltip Fr");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(3, (select id from LANGUES where ISO="nl"), "Text nl", "Text tooltip nl");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(3, (select id from LANGUES where ISO="de"), "Text de", "Text tooltip de");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(3, (select id from LANGUES where ISO="en"), "Text en", "Text tooltip en");

INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(4, (select id from LANGUES where ISO="fr"), "HTML Fr", "HTML tooltip Fr");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(4, (select id from LANGUES where ISO="nl"), "HTML nl", "HTML tooltip nl");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(4, (select id from LANGUES where ISO="de"), "HTML de", "HTML tooltip de");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(4, (select id from LANGUES where ISO="en"), "HTML en", "HTML tooltip en");

INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(5, (select id from LANGUES where ISO="fr"), "checked Fr", "checked tooltip Fr");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(5, (select id from LANGUES where ISO="nl"), "checked nl", "checked tooltip nl");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(5, (select id from LANGUES where ISO="de"), "checked de", "checked tooltip de");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(5, (select id from LANGUES where ISO="en"), "checked en", "checked tooltip en");

INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(6, (select id from LANGUES where ISO="fr"), "Date Fr", "Date tooltip Fr");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(6, (select id from LANGUES where ISO="nl"), "Date nl", "Date tooltip nl");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(6, (select id from LANGUES where ISO="de"), "Date de", "Date tooltip de");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(6, (select id from LANGUES where ISO="en"), "Date en", "Date tooltip en");

INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(7, (select id from LANGUES where ISO="fr"), "Interval Fr", "Interval tooltip Fr");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(7, (select id from LANGUES where ISO="nl"), "Interval nl", "Interval tooltip nl");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(7, (select id from LANGUES where ISO="de"), "Interval de", "Interval tooltip de");
INSERT INTO PROPERTY_INFO (PROP_ID, LNG_ID, LABEL, TOOLTIP) VALUES(7, (select id from LANGUES where ISO="en"), "Interval en", "Interval tooltip en");

INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(1, (select id from LANGUES where ISO="fr"), "Panel fr", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(1, (select id from LANGUES where ISO="nl"), "Panel nl", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(1, (select id from LANGUES where ISO="de"), "Panel de", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(1, (select id from LANGUES where ISO="en"), "Panel en", 1);

INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(2, (select id from LANGUES where ISO="fr"), "String value fr", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(2, (select id from LANGUES where ISO="nl"), "String value nl", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(2, (select id from LANGUES where ISO="de"), "String value de", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_SHORT, DOCUMENT_ID) VALUES(2, (select id from LANGUES where ISO="en"), "String value en", 1);

INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(3, (select id from LANGUES where ISO="fr"), "Text value fr", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(3, (select id from LANGUES where ISO="nl"), "Text value nl", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(3, (select id from LANGUES where ISO="de"), "Text value de", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(3, (select id from LANGUES where ISO="en"), "Text value en", 1);

INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(4, (select id from LANGUES where ISO="fr"), "HTML value fr", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(4, (select id from LANGUES where ISO="nl"), "HTML value nl", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(4, (select id from LANGUES where ISO="de"), "HTML value de", 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_TEXT, DOCUMENT_ID) VALUES(4, (select id from LANGUES where ISO="en"), "HTML value en", 1);

INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, CHECKED, DOCUMENT_ID) VALUES(5, (select id from LANGUES where ISO="fr"), 1, 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, CHECKED, DOCUMENT_ID) VALUES(5, (select id from LANGUES where ISO="nl"), 1, 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, CHECKED, DOCUMENT_ID) VALUES(5, (select id from LANGUES where ISO="de"), 1, 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, CHECKED, DOCUMENT_ID) VALUES(5, (select id from LANGUES where ISO="en"), 1, 1);

INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM, DOCUMENT_ID) VALUES(6, (select id from LANGUES where ISO="fr"), '1977-01-22', 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM, DOCUMENT_ID) VALUES(6, (select id from LANGUES where ISO="nl"), '1977-01-22', 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM, DOCUMENT_ID) VALUES(6, (select id from LANGUES where ISO="de"), '1977-01-22', 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM, DOCUMENT_ID) VALUES(6, (select id from LANGUES where ISO="en"), '1977-01-22', 1);

INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM,VALUE_DATE_TO, DOCUMENT_ID) VALUES(7, (select id from LANGUES where ISO="fr"), '1977-01-22', '1977-01-23', 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM,VALUE_DATE_TO, DOCUMENT_ID) VALUES(7, (select id from LANGUES where ISO="nl"), '1977-01-22', '1977-01-23', 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM,VALUE_DATE_TO, DOCUMENT_ID) VALUES(7, (select id from LANGUES where ISO="de"), '1977-01-22', '1977-01-23', 1);
INSERT INTO PROPERTY_VALUES (PROP_ID, LNG_ID, VALUE_DATE_FROM,VALUE_DATE_TO, DOCUMENT_ID) VALUES(7, (select id from LANGUES where ISO="en"), '1977-01-22', '1977-01-23', 1);