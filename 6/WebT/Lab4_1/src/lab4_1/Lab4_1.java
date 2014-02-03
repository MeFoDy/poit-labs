/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab4_1;

/**
 *
 * @author Dark_MeFoDy
 */
public class Lab4_1 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        MyList bb = new MyList();
        
        for (Double z = 25.; z > 14.; z--) {
            bb.add(z);
        }
        for (Double z = 14.5; z < 27.5; z+=2) {
            System.out.println("Для " + z + " ближайший элемент - " + bb.getNearest(z));
        }
    }
}
