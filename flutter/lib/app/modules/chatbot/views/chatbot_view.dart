import 'package:eatwise/app/modules/bottomnavigation/views/bottomnavigation_view.dart';
import 'package:eatwise/app/routes/app_pages.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:iconsax/iconsax.dart';
import '../controllers/chatbot_controller.dart';

class ChatbotView extends GetView<ChatbotController> {
  const ChatbotView({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          // Header with centered "Chat with us!" text
          Container(
            color: const Color(0xFFD91C1C),
            padding:
                const EdgeInsets.only(top: 60, bottom: 0, left: 16, right: 16),
            child: Center(
              child: Text(
                "Chat with us!",
                style: GoogleFonts.poppins(
                  color: Colors.white,
                  fontSize: 16,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ),

          Container(
            color: const Color(0xFFD91C1C),
            padding:
                const EdgeInsets.only(top: 16, bottom: 30, left: 16, right: 16),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Row(
                  children: [
                    Container(
                      width: 50,
                      height: 50,
                      decoration: const BoxDecoration(
                        color: Colors.white,
                        shape: BoxShape.circle,
                      ),
                      child: Center(
                        child: Container(
                          width: 40,
                          height: 40,
                          child: const Icon(
                            Icons.chat_bubble,
                            color: Colors.red,
                            size: 23,
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          "Chatbot",
                          style: GoogleFonts.poppins(
                            fontWeight: FontWeight.bold,
                            fontSize: 16,
                            color: Colors.white,
                          ),
                        ),
                        Text(
                          "Support Agent",
                          style: GoogleFonts.poppins(
                            color: Colors.white70,
                            fontSize: 14,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
                Row(
                  children: [
                    Container(
                      padding: const EdgeInsets.all(8),
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.2),
                        shape: BoxShape.circle,
                      ),
                      child: const Icon(Icons.thumb_up, color: Colors.white),
                    ),
                    const SizedBox(width: 12),
                  ],
                ),
              ],
            ),
          ),
          Expanded(
            child: Container(
              color: const Color(0xFFF5F5F5),
              child: Obx(() {
                return ListView.builder(
                  padding: const EdgeInsets.all(16),
                  controller: controller.scrollController,
                  itemCount: controller.chatMessages.length,
                  itemBuilder: (context, index) {
                    final message = controller.chatMessages[index];
                    final isUser = message.isUser;

                    return Column(
                      crossAxisAlignment: isUser
                          ? CrossAxisAlignment.end
                          : CrossAxisAlignment.start,
                      children: [
                        Text(
                          isUser
                              ? "Visitor ${message.timestamp}"
                              : "LiveChat ${message.timestamp}",
                          style: GoogleFonts.poppins(
                            color: Colors.grey[700],
                            fontSize: 12,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Container(
                          margin: EdgeInsets.only(
                            top: 8,
                            bottom: 16,
                            left: isUser ? 100 : 18,
                            right: isUser ? 18 : 100,
                          ),
                          padding: const EdgeInsets.all(16),
                          decoration: BoxDecoration(
                            color:
                                isUser ? const Color(0xFFD91C1C) : Colors.white,
                            borderRadius: BorderRadius.circular(12),
                            border: isUser
                                ? null
                                : Border.all(color: Colors.grey, width: 0.5),
                          ),
                          child: Text(
                            message.text,
                            style: GoogleFonts.poppins(
                              fontSize: 14,
                              color: isUser
                                  ? Colors.white
                                  : const Color(0xff667085),
                            ),
                          ),
                        ),
                      ],
                    );
                  },
                );
              }),
            ),
          ),

          Padding(
            padding: const EdgeInsets.all(16),
            child: Container(
              decoration: BoxDecoration(
                color: Colors.white,
                border: Border.all(color: Colors.grey.shade400, width: 0.5),
                borderRadius: BorderRadius.circular(30),
              ),
              child: Row(
                children: [
                  Expanded(
                    child: TextField(
                      controller:
                          controller.messageController, // ✅ this is essential!
                      decoration: InputDecoration(
                        hintText: "Ask anything",
                        hintStyle: GoogleFonts.poppins(
                            fontSize: 14, fontWeight: FontWeight.w400),
                        border: InputBorder.none,
                        contentPadding: const EdgeInsets.symmetric(
                            horizontal: 16, vertical: 12),
                      ),
                      maxLines: 1,
                    ),
                  ),
                  GestureDetector(
                    onTap: controller.sendMessage,
                    child: Padding(
                      padding: const EdgeInsets.all(8.0),
                      child: Image.asset(
                        'assets/images/send.png',
                        width: 26,
                        height: 26,
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
      bottomNavigationBar: BottomnavigationView(
        currentIndex: 2,
        onTap: (index) {
          switch (index) {
            case 0:
              Get.offNamed(Routes.HOME);
              break;
            case 1:
              Get.offNamed(Routes.RECIPE);
              break;
            case 2:
              break;
            case 3:
              Get.offNamed(Routes.PROFILE);
              break;
          }
        },
      ),
    );
  }
}
