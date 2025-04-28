import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class BottomnavigationView extends StatelessWidget {
  final int currentIndex;
  final Function(int) onTap;

  const BottomnavigationView({
    Key? key,
    required this.currentIndex,
    required this.onTap,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 75,
      padding: EdgeInsetsDirectional.symmetric(horizontal: 18.5),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(
          topLeft: Radius.circular(30),
          topRight: Radius.circular(30),
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black12,
            blurRadius: 16,
            offset: Offset(0, -5),
          ),
        ],
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.only(
          topLeft: Radius.circular(30),
          topRight: Radius.circular(30),
        ),
        child: Theme(
          data: ThemeData(
            splashColor: Colors.transparent,
            highlightColor: Colors.transparent,
          ),
          child: BottomNavigationBar(
            currentIndex: currentIndex,
            onTap: onTap,
            type: BottomNavigationBarType.fixed,
            backgroundColor: Colors.white,
            elevation: 0,
            selectedItemColor: Color(0xffCE181B),
            unselectedItemColor: Colors.grey,
            selectedLabelStyle: GoogleFonts.poppins(
              fontSize: 12,
              fontWeight: FontWeight.w600,
            ),
            unselectedLabelStyle: GoogleFonts.poppins(
              fontSize: 12,
            ),
            iconSize: 28,
            selectedFontSize: 8, 
            unselectedFontSize: 8,
            items: [
              BottomNavigationBarItem(
                icon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child: Image.asset('assets/images/explore_grey.png',height: 25, width: 25),
                ),
                activeIcon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child:Image.asset('assets/images/explore_red.png',height: 25, width: 25),
                ),
                label: 'Explore',
              ),
              BottomNavigationBarItem(
                icon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child: Image.asset('assets/images/recipe_grey.png',height: 26,width: 26),
                ),
                activeIcon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child:Image.asset('assets/images/recipe_red.png',height: 25, width: 25),
                ),
                label: 'Recipe',
              ),
              BottomNavigationBarItem(
                icon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child: Image.asset('assets/images/chatbot_grey.png',height: 25,width: 25),
                ),
                activeIcon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child: Image.asset('assets/images/chatbot_red.png',height: 25,width: 25),
                ),
                label: 'Chatbot',
              ),
              BottomNavigationBarItem(
                icon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child: Image.asset('assets/images/profile_grey.png',height: 25,width: 25),
                ),
                activeIcon: Padding(
                  padding: const EdgeInsets.only(bottom: 4, top: 8),
                  child: Image.asset('assets/images/profile_red.png',height: 25,width: 25),
                ),
                label: 'Profile',
              ),
            ],
          ),
        ),
      ),
    );
  }
}