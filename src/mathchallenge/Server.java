package mathchallenge;

import com.mysql.cj.Session;
import com.mysql.cj.protocol.Message;
import java.io.*;
import java.net.*;
import java.sql.*;
import java.util.*;
import java.util.Properties;
import javax.mail.*;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import javax.mail.MessagingException;
import javax.mail.PasswordAuthentication;
import javax.mail.internet.*;





public class Server {
    private static final String EMAIL_FROM = "admin@mathcompetition.com";
    private static final String EMAIL_HOST = "smtp.example.com";
    private static final String DB_URL = "jdbc:mysql://localhost:3306/math_competition_db";
    private static final String DB_USER = "root";
    private static final String DB_PASSWORD = "";

    private static Map<String, String> registeredSchools = new HashMap<>();

    static {
        registeredSchools.put("SCH123", "rep1@school.com");
        registeredSchools.put("SCH456", "rep2@school.com");
        // Add more schools as needed
    }

   public static boolean validateSchoolNumber(String schoolNumber) {
    return registeredSchools.containsKey(schoolNumber);
}

public static void addRecordToFile(String applicantName, String schoolNumber) {
    try (FileWriter writer = new FileWriter("applicants.txt", true)) {
        writer.write("Applicant: " + applicantName + ", School Number: " + schoolNumber + "\n");
        System.out.println("Record added successfully.");
    } catch (IOException e) {
        e.printStackTrace();
    }
}

public static void sendEmailNotification(String schoolNumber, String applicantName) {
    String to = registeredSchools.get(schoolNumber);
    String from = "admin@mathcompetition.com";
    String host = "smtp.example.com";

    Properties properties = System.getProperties();
    properties.setProperty("mail.smtp.host", host);
    properties.put("mail.smtp.auth", "true");
    properties.put("mail.smtp.starttls.enable", "true");

    javax.mail.Session session = Session.getDefaultInstance(properties);

    try {
        MimeMessage message = new MimeMessage(session);
        message.setFrom(new InternetAddress(from));
        message.addRecipient(Message.RecipientType.TO, new InternetAddress(to));
        message.setSubject("Applicant Confirmation Needed");
        message.setText("Dear School Representative,\n\nPlease confirm the registration of the applicant: " + applicantName + ".\n\nThank you.");

        Transport.send(message);
        System.out.println("Email sent successfully to: " + to);
    } catch (MessagingException mex) {
        mex.printStackTrace();
    }
}

public static String[] getApplicantDetails(String applicantId) {
    String[] details = new String[2];
    try {
        Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/math_competition_db", "root", "");
        Statement stmt = conn.createStatement();
        String query = "SELECT applicantName, schoolNumber FROM applicants WHERE applicantId = '" + applicantId + "'";
        ResultSet rs = stmt.executeQuery(query);
        if (rs.next()) {
            details[0] = rs.getString("applicantName");
            details[1] = rs.getString("schoolNumber");
        }
        conn.close();
    } catch (Exception e) {
        e.printStackTrace();
    }
    return details;
}


    private static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
    }

    public static void handleRegistration(BufferedReader in, PrintWriter out) throws IOException {
        String input = in.readLine();
        String[] details = input.split(",");

        if (details.length != 7) {
            out.println("Invalid registration details. Please provide all required fields.");
            return;
        }

        String username = details[0].trim();
        String firstname = details[1].trim();
        String lastname = details[2].trim();
        String emailAddress = details[3].trim();
        String dateOfBirth = details[4].trim();
        String schoolRegistrationNumber = details[5].trim();
        String imageFile = details[6].trim();

        Participant participant = new Participant(username, firstname, lastname, emailAddress, dateOfBirth, schoolRegistrationNumber, imageFile);

        String validationMessage = ParticipantValidator.validate(participant);
        if (!validationMessage.equals("Participant is valid.")) {
            out.println("Registration failed: " + validationMessage);
            return;
        }

        String query = "INSERT INTO participants (username, firstname, lastname, emailAddress, dateOfBirth, schoolRegistrationNumber, imageFile) VALUES (?, ?, ?, ?, ?, ?, ?)";
        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(query)) {

            stmt.setString(1, participant.getUsername());
            stmt.setString(2, participant.getFirstname());
            stmt.setString(3, participant.getLastname());
            stmt.setString(4, participant.getEmailAddress());
            stmt.setString(5, participant.getDateOfBirth());
            stmt.setString(6, participant.getSchoolRegistrationNumber());
            stmt.setString(7, participant.getImageFile());
            stmt.executeUpdate();

            // Send email notification to school representative
            sendEmailToSchoolRep(participant.getSchoolRegistrationNumber(), participant.getUsername());

            out.println("Registration successful for " + username);
        } catch (SQLException e) {
            e.printStackTrace();
            out.println("Registration failed: " + e.getMessage());
        }
    }

    public static void sendEmailToSchoolRep(String schoolRegistrationNumber, String username) {
        String to = registeredSchools.get(schoolRegistrationNumber);
        String subject = "New Participant Registration";
        String body = "A new participant with username " + username + " has registered. Please confirm.";
        sendEmailNotification(to, subject, body);
    }

    private static void sendEmailNotification(String to, String subject, String body) {
        // TODO Auto-generated method stub
        throw new UnsupportedOperationException("Unimplemented method 'sendEmailNotification'");
    }

    public static void handleAttemptChallenge(BufferedReader in, PrintWriter out) throws IOException {
        String challengeNumber = in.readLine();

        String query = "SELECT question_id, question_text FROM questions WHERE challenge_number = ?";
        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(query)) {

            stmt.setString(1, challengeNumber);
            ResultSet rs = stmt.executeQuery();

            List<String> questions = new ArrayList<>();
            while (rs.next()) {
                questions.add(rs.getString("question_text"));
            }

            if (questions.isEmpty()) {
                out.println("No questions found for this challenge.");
                return;
            }

            // Shuffle and select 20 questions
            Collections.shuffle(questions);
            List<String> selectedQuestions = questions.subList(0, Math.min(20, questions.size()));

            // Send selected questions to the client
            for (int i = 0; i < selectedQuestions.size(); i++) {
                out.println("Question " + (i + 1) + ": " + selectedQuestions.get(i));
            }
            out.println("---");

            // Handle client responses
            for (int i = 0; i < selectedQuestions.size(); i++) {
                String answer = in.readLine();
                out.println("Received answer for Question " + (i + 1) + ": " + answer);
            }

            out.println("Challenge completed.");
        } catch (SQLException e) {
            e.printStackTrace();
            out.println("Error handling challenge: " + e.getMessage());
        }
    }

    public static void handleViewChallenges(PrintWriter out) {
        // Dummy implementation for viewing challenges
        out.println("Challenge 1: Mathematics Challenge 2024");
        out.println("Challenge 2: Mathematics Challenge 2023");
        out.println("---");
    }

    public static void handleViewApplicants(PrintWriter out) {
        // Dummy implementation for viewing applicants
        out.println("Applicant 1: John Doe, Registration Number: 1234");
        out.println("Applicant 2: Jane Smith, Registration Number: 5678");
        out.println("---");
    }

    public static void handleConfirm(BufferedReader in, PrintWriter out) throws IOException {
        String input = in.readLine();
        String[] details = input.split(" ");

        if (details.length != 3) {
            out.println("Invalid confirmation details. Please provide yes/no, username, and school number.");
            return;
        }

        String response = details[0].trim();
        String username = details[1].trim();
        String schoolNumber = details[2].trim();

        if (response.equalsIgnoreCase("yes")) {
            // Confirm registration
            removePendingParticipant(username);
            out.println("Registration confirmed for " + username);
        } else if (response.equalsIgnoreCase("no")) {
            // Move to rejected list
            moveToRejected(username);
            out.println("Registration rejected for " + username);
        } else {
            out.println("Invalid confirmation response. Use 'yes' or 'no'.");
        }
    }

    public static void removePendingParticipant(String username) {
        String query = "DELETE FROM pending_participants WHERE username = ?";
        try (Connection conn = getConnection();
             PreparedStatement stmt = conn.prepareStatement(query)) {
            stmt.setString(1, username);
            stmt.executeUpdate();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void moveToRejected(String username) {
        // Implement logic to move participant to rejected list
    }

    public static void main(String[] args) {
        try (ServerSocket serverSocket = new ServerSocket(8080)) {
            System.out.println("Server is running...");
            while (true) {
                Socket clientSocket = serverSocket.accept();
                new ClientHandler(clientSocket).start();
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}

class ClientHandler extends Thread {
    private Socket socket;

    public ClientHandler(Socket socket) {
        this.socket = socket;
    }

    @Override
    public void run() {
        try (BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
             PrintWriter out = new PrintWriter(socket.getOutputStream(), true)) {

            String action;
            while ((action = in.readLine()) != null) {
                switch (action.toLowerCase()) {
                    case "register":
                        Server.handleRegistration(in, out);
                        break;
                    case "viewchallenges":
                        Server.handleViewChallenges(out);
                        break;
                    case "attemptchallenge":
                        Server.handleAttemptChallenge(in, out);
                        break;
                    case "viewapplicants":
                        Server.handleViewApplicants(out);
                        break;
                    case "confirm":
                        Server.handleConfirm(in, out);
                        break;
                    default:
                        out.println("Invalid action.");
                        break;
                }
            }
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
