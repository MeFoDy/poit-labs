/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package newpackage;

import java.io.File;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.Iterator;
import java.util.List;
import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;

import javax.servlet.ServletException;
import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.FileUploadException;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;

public class FileParser extends HttpServlet {

    /**
     * Processes requests for both HTTP
     * <code>GET</code> and
     * <code>POST</code> methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        try {
            /* TODO output your page here. You may use following sample code. */
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Servlet FileParser</title>");
            out.println("</head>");
            out.println("<body>");
            out.println("<h1>Servlet FileParser at " + request.getContextPath() + "</h1>");
            out.println("</body>");
            out.println("</html>");
        } finally {
            out.close();
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP
     * <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP
     * <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        //processRequest(request, response);

        PrintWriter out = response.getWriter();
        if (!ServletFileUpload.isMultipartContent(request)) {
            response.sendError(HttpServletResponse.SC_BAD_REQUEST);
            return;
        }
        DiskFileItemFactory factory = new DiskFileItemFactory();
        factory.setSizeThreshold(1024 * 1024);
        File tempDir = (File) getServletContext().getAttribute("javax.servlet.context.tempdir");
        factory.setRepository(tempDir);
        ServletFileUpload upload = new ServletFileUpload(factory);
        upload.setSizeMax(1024 * 1024 * 10);
        FileUploader uploader = new FileUploader();
        List items = null;
        try {
            items = upload.parseRequest(request);
            //upload.is
        } catch (FileUploadException ex) {
            Logger.getLogger(FileParser.class.getName()).log(Level.SEVERE, null, ex);
        }
        Iterator iter = items.iterator();
        String filepath = null;
        while (iter.hasNext()) {
            FileItem item = (FileItem) iter.next();
            if (!item.isFormField()) {
                try {
                    Cookie[] cookies = request.getCookies();
                    filepath = uploader.Upload(item, getServletContext().getRealPath("/upload/"));
                } catch (Exception ex) {
                    Logger.getLogger(FileParser.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }
        TextFileParser parser = new TextFileParser();
        MailInfo mailInfo = parser.Parse(filepath, "*", "!");
        out.println("<html>");
        out.println("<head>");
        out.println("</head>");
        out.println("<body>");
        response.getWriter().println("Count of e-mail: " + mailInfo.getNumber());
        for (int i=0; i<mailInfo.list.size(); i++) {
            response.getWriter().println("<br>");
            response.getWriter().println(mailInfo.list.get(i));
            
        }
        out.println("</body>");
        out.println("</html>");
        Cookie cookie = new Cookie("Mail", mailInfo.toString());
        cookie.setMaxAge(3600);
        response.addCookie(cookie);
        out.close();


    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>
}
