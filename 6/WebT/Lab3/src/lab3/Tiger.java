/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab3;

/**
 *
 * @author Dark_MeFoDy
 */
public class Tiger {
    Kogti kogti = new Kogti(20);
    private String name;
    
    public Tiger(String name, int kogtiCount) {
        this.name = name;
        kogti = new Kogti(kogtiCount);
    }
    
    public void Richat() {
        System.out.println(name + ": рычу");
    }
    public void Run() {
        System.out.println(name + ": бегу");
    }
    public void GetPischa() {
        Run();
        kogti.Use();
        System.out.println(name + ": добываю пищу");
    }
}
