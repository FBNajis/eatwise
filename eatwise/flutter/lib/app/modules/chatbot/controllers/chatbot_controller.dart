import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter_dotenv/flutter_dotenv.dart';

final apiKey = dotenv.env['API_KEY'];

class ChatMessage {
  final String text;
  final bool isUser;
  final String timestamp;
  final bool isRead;

  ChatMessage({
    required this.text,
    required this.isUser,
    required this.timestamp,
    this.isRead = false,
  });
}

class ChatbotController extends GetxController {
  final messageController = TextEditingController();
  final chatMessages = <ChatMessage>[].obs;
  final scrollController = ScrollController();

  @override
  void onInit() {
    super.onInit();
    addBotMessage("Welcome to LiveChat");
  }

  @override
  void onClose() {
    messageController.dispose();
    scrollController.dispose();
    super.onClose();
  }

  void _scrollToBottom() {
    Future.delayed(Duration(milliseconds: 300), () {
      if (scrollController.hasClients) {
        scrollController.animateTo(
          scrollController.position.maxScrollExtent,
          duration: Duration(milliseconds: 300),
          curve: Curves.easeOut,
        );
      }
    });
  }

  void sendMessage() async {
    if (messageController.text.trim().isNotEmpty) {
      final String userMessage = messageController.text;
      final now = DateTime.now();
      final String formattedTime =
          "${now.hour.toString().padLeft(2, '0')}:${now.minute.toString().padLeft(2, '0')}";

      // Add user message to chat
      chatMessages.add(ChatMessage(
        text: userMessage,
        isUser: true,
        timestamp: formattedTime,
        isRead: false,
      ));

      messageController.clear();
      _scrollToBottom();

      // Mark user message as read after delay (optional visual effect)
      Future.delayed(const Duration(seconds: 1), () {
        final index = chatMessages.length - 1;
        if (index >= 0) {
          final message = chatMessages[index];
          chatMessages[index] = ChatMessage(
            text: message.text,
            isUser: message.isUser,
            timestamp: message.timestamp,
            isRead: true,
          );
        }
      });
      final url = Uri.parse('https://api.groq.com/openai/v1/chat/completions');
      try {
        final response = await http.post(
          url,
          headers: {
            'Authorization': 'Bearer $apiKey', // make sure dotenv is loaded!
            'Content-Type': 'application/json',
          },
          body: jsonEncode({
            'model': 'llama3-70b-8192',
            'messages': [
              {'role': 'user', 'content': userMessage}
            ]
          }),
        );

        if (response.statusCode == 200) {
          final data = jsonDecode(response.body);
          final botReply = data['choices'][0]['message']['content'];
          addBotMessage(botReply);
        } else {
          print("Failed: ${response.body}");
          addBotMessage("Sorry, something went wrong.");
        }
      } catch (e) {
        addBotMessage("Error: ${e.toString()}");
      }
      print("API_KEY: ${dotenv.env['API_KEY']}");
    }
    _scrollToBottom();
  }

  void addBotMessage(String message) {
    final now = DateTime.now();
    final String formattedTime =
        "${now.hour.toString().padLeft(2, '0')}:${now.minute.toString().padLeft(2, '0')} PM";

    chatMessages.add(ChatMessage(
      text: message,
      isUser: false,
      timestamp: formattedTime,
    ));
  }
}
