// Track which section is in view and highlight the corresponding menu link
(function() {
  const sections = ['servicios', 'materiales', 'precios'];
  const menuLinks = document.querySelectorAll('.menu-nav-link');

  function updateActiveMenuLink() {
    let current = '';
    
    sections.forEach((sectionId) => {
      const section = document.getElementById(sectionId);
      if (section) {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        // Check if section is in viewport (with 200px offset from top)
        if (window.scrollY >= sectionTop - 200) {
          current = sectionId;
        }
      }
    });

    // Update all menu links
    menuLinks.forEach((link) => {
      const linkSection = link.getAttribute('data-section');
      
      if (linkSection === current) {
        link.classList.add('menu__link--select');
      } else {
        link.classList.remove('menu__link--select');
      }
    });
  }

  // Update on scroll
  window.addEventListener('scroll', updateActiveMenuLink);
  
  // Smooth scroll on click
  menuLinks.forEach((link) => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('href').substring(1);
      const targetSection = document.getElementById(targetId);
      if (targetSection) {
        targetSection.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // Initial call
  updateActiveMenuLink();
})();
