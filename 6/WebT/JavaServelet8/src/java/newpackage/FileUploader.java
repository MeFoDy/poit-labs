/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package newpackage;

import java.io.File;
import java.util.Random;

public class FileUploader {
     private String magicString="1!2!3!";
     public String Upload(org.apache.commons.fileupload.FileItem item,String dest) throws Exception {
        File uploadetFile = null;        
        Random random = new Random();
        //выбираем файлу имя пока не найдём свободное
        String path=null;
        do {
            path = dest+ "/"+random.nextInt()+magicString+ item.getName();
            uploadetFile = new File(path);
        } while (uploadetFile.exists());
        //создаём файл
        uploadetFile.createNewFile();
        //записываем в него данные        
        item.write(uploadetFile);        
        return path;
    }  
}