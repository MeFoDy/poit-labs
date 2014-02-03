/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab3;

/**
 *
 * @author Dark_MeFoDy
 */
public class Kogti {
    int count;
    
    public void Use() {
        System.out.println("Используем когти");
    }
    
    public Kogti(int count) {
        if (count < 0 || count > 20) {
            throw new IllegalArgumentException("Когтей не может быть меньше 0 или больше 20");
        }
    }
}
