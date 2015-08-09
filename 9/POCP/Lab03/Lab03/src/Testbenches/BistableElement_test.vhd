library ieee;
use     ieee.std_logic_1164.all;
use     ieee.std_logic_unsigned.all;
use 	std.textio.all;

entity BistableElement_test is
end    BistableElement_test;

architecture Beh of BistableElement_test is
	component BistableElement
		port(
			Q: out std_logic;
			nQ: out std_logic
			);
	end component;
	
	signal res, nRes: std_logic;
begin
	BistableBeh: entity BistableElement(Struct) port map(
		Q => res,
		nQ => nRes
		);
end Beh;