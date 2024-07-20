package mathchallenge;

import javax.mail.*;
import javax.mail.internet.*;
import java.io.*;
import java.net.*;
import java.sql.*;
import java.util.*;
import java.util.Properties;

public class Server {
    private static final int PORT = 8080;

    public static void main(String[] args) {
        new Server().start();
    }

    public void start() {
        try (ServerSocket serverSocket = new ServerSocket(PORT)) {
            System.out.println("Server is listening on port " + PORT);

            while (true) {
                Socket socket = serverSocket.accept();
                System.out.println("New client connected");

                new ClientHandler(socket).start();
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
                        handleRegistration(in, out);
                        break;
                    case "viewchallenges":
                        handleViewChallenges(out);
                        break;
                    case "attemptchallenge":
                        handleAttemptChallenge(in, out);
                        break;
                    case "viewapplicants":
                        handleViewApplicants(out);
                        break;
                    case "confirm":
                        handleConfirm(in, out);
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

    private void handleRegistration(BufferedReader in, PrintWriter out) throws IOException {
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

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/math_competition_db", "root", "");
             PreparedStatement stmt = conn.prepareStatement("INSERT INTO participants (username, firstname, lastname, emailAddress, dateOfBirth, schoolRegistrationNumber, imageFile) VALUES (?, ?, ?, ?, ?, ?, ?)")) {

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

    private void handleViewChallenges(PrintWriter out) {
        // Dummy implementation for viewing challenges
        out.println("Challenge 1: Mathematics Challenge 2024");
        out.println("Challenge 2: Mathematics Challenge 2023");
        out.println("---");
    }

    private void handleAttemptChallenge(BufferedReader in, PrintWriter out) throws IOException {
        String challengeNumber = in.readLine();

        try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/math_competition_db", "root", "");
             Statement stmt = conn.createStatement()) {

            // Retrieve questions for the selected challenge
            ResultSet rs = stmt.executeQuery("SELECT question_id, question_text FROM questions WHERE challenge_number = '" + challengeNumber + "'");
            
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
                // Process the answer, e.g., save it to the database or validate it
                out.println("Received answer for Question " + (i + 1) + ": " + answer);
            }

            out.println("Challenge completed.");
        } catch (SQLException e) {
            e.printStackTrace();
            out.println("Error handling challenge: " + e.getMessage());
        }
    }

    private void handleViewApplicants(PrintWriter out) {
        // Dummy implementation for viewing applicants
        // Implement actual logic to read from a file or database
        out.println("Applicant 1: John Doe, Registration Number: 1234");
        out.println("Applicant 2: Jane Smith, Registration Number: 5678");
        out.println("---");
    }

    private void handleConfirm(BufferedReader in, PrintWriter out) throws IOException {
        String input = in.readLine();
        String[] details = input.split(" ");
        
        if (details.length != 3) {
            out.println("Invalid confirmation details. Please provide 'yes/no username schoolNumber'.");
            return;
        }

        String confirmation = details[0].trim();
        String username = details[1].trim();
        String schoolRegistrationNumber = details[2].trim();

        if (confirmation.equalsIgnoreCase("yes")) {
            // Accept the participant
            try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/math_competition_db", "root", "");
                 PreparedStatement stmt = conn.prepareStatement("INSERT INTO participants (username, schoolRegistrationNumber) SELECT username, ? FROM pending_participants WHERE username = ?")) {
                 
                stmt.setString(1, schoolRegistrationNumber);
                stmt.setString(2, username);
                stmt.executeUpdate();

                // Remove from pending and notify participant
                removePendingParticipant(username);
                sendEmailToParticipant(username, "accepted");

                out.println("Participant " + username + " accepted.");
            } catch (SQLException e) {
                e.printStackTrace();
                out.println("Error accepting participant: " + e.getMessage());
            }
        } else if (confirmation.equalsIgnoreCase("no")) {
            // Reject the participant
            try (Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/math_competition_db", "root", "");
                 PreparedStatement stmt = conn.prepareStatement("DELETE FROM pending_participants WHERE username = ?")) {

                stmt.setString(1, username);
                stmt.executeUpdate();

                // Move to rejected and notify participant
                moveToRejected(username);
                sendEmailToParticipant(username, "rejected");

                out.println("Participant " + username + " rejected.");
            } catch (SQLException e) {
                e.printStackTrace();
                out.println("Error rejecting participant: " + e.getMessage());
            }
        } else {
            out.println("Invalid confirmation action. Use 'yes' or 'no'.");
        }
    }

    private void sendEmailToSchoolRep(String schoolRegistrationNumber, String username) {
        // Email configuration
        String from = "your_email@example.com"; // Update with your email
        String host = "smtp.example.com"; // Update with your SMTP server

        // Placeholder for recipient email. Replace with actual logic to get recipient email from schoolRegistrationNumber
        String to = "school_rep@example.com"; 

        String subject = "New Participant Registration";
        String body = "A new participant with username " + username + " has registered. Please confirm.";

        sendEmail(from, to, host, subject, body);
    }

    private void sendEmailToParticipant(String username, String status) {
        // Email configuration
        String from = "your_email@example.com"; // Update with your email
        String host = "smtp.example.com"; // Update with your SMTP server

        // Placeholder for participant email. Replace with actual logic to get participant email from username
        String to = "participant@example.com";

        String subject = "Registration Status";
        String body = "Your registration status is: " + status;

        sendEmail(from, to, host, subject, body);
    }

    private void sendEmail(String from, String to, String host, String subject, String body) {
        Properties properties = System.getProperties();
        properties.setProperty("mail.smtp.host", host);
        Session session = Session.getDefaultInstance(properties);

        try {
            MimeMessage message = new MimeMessage(session);
            message.setFrom(new InternetAddress(from));
            message.addRecipient(Message.RecipientType.TO, new InternetAddress(to));
            message.setSubject(subject);
            message.setText(body);

            Transport.send(message);
            System.out.println("Email sent successfully to " + to);
        } catch (MessagingException mex) {
            mex.printStackTrace();
        }
    }

    private void removePendingParticipant(String username) {
        // Implement logic to remove participant from the pending list
    }

    private void moveToRejected(String username) {
        // Implement logic to move participant to rejected list
    }
}
