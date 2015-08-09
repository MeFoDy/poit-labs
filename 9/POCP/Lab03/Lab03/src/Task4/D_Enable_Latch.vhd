library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity D_Enable_Latch is
	port (
		D, E : in std_logic;
		Q : out std_logic;
		nQ : out std_logic
		);
end D_Enable_Latch;

architecture Struct of D_Enable_Latch is 
	component nor2 
		port (
			a, b: in std_logic;
			z : out std_logic);
	end component;
	component inv
		port (
			a: in std_logic;
			z: out std_logic);
	end component;
	component and2 
		port (
			a, b: in std_logic;
			z : out std_logic);
	end component;
	signal d_t, ea_t, n_t1, n_t2, da_t : std_logic;
begin
	U1: and2 port map (a => E, b => D, z => ea_t);
	U2: inv port map (a => D, z => d_t);
	U3: and2 port map (a => d_t, b => e, z => da_t);
	U4: nor2 port map (a => ea_t, b => n_t2, z => n_t1);
	U5: nor2 port map (a => da_t, b => n_t1, z => n_t2);
	Q <= n_t2;
	nQ <= n_t1;
end Struct;

architecture Beh of D_Enable_Latch is
    signal data : std_logic;
begin
    data <= D when (E = '1') else data;
    Q <= data;
	nQ <= not data;
end Beh;