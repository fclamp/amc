KE EMu EXAMPLE PDA INTERFACE
============================
Written by:	Alex Fell
Contact:	alex.fell@kesoftware.com

The following is an example of how to construct a PDA interface for KE EMu. It
also demonstrates use of the RecordExtractor and RecordsListExtractor objects
to construct Display and Results List pages.

If varied customisation is required it would perhaps be benificial to modify
this code to incorporate variables from a config file, or wrap it inside a
class / classes, however it is unlikely that PDA interfaces would require the
same amount of customisation as stardard EMu web interfaces.

For further information on the RecordExtractor and RecordListExtractor classes
see the source files in web/objects/common; there are many methods and
properties available beyond those used in this example.
