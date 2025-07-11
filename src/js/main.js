const navItems = document.querySelector('.nav-items');
const openNavBtn = document.querySelector('#open-nav-btn');
const closeNavBtn = document.querySelector('#close-nav-btn');

const openNav = () => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block';
 }
 openNavBtn.addEventListener('click' , openNav);

 const closeNav = () => {
    navItems.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
    closeNavBtn.style.display = 'none';
 }
 closeNavBtn.addEventListener('click' , closeNav);




 const sidebar = document.querySelector('aside');
 const showSidebarBtn = document.querySelector('#show-sidebar-btn');
 const hideSidebarBtn = document.querySelector('#hide-sidebar-btn');


 const showSidebar = () =>{
   sidebar.style.left= '0';
   showSidebarBtn.style.display='none';
   hideSidebarBtn.style.display='inline-block';
 }
 showSidebarBtn.addEventListener('click' , showSidebar);


 const hideSidebar = () =>{
   sidebar.style.left= '-100%';
   showSidebarBtn.style.display='inline-block';
   hideSidebarBtn.style.display='none';
 }
 hideSidebarBtn.addEventListener('click' , hideSidebar);