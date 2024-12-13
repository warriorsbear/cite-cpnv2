// Tests de la page Messagerie
describe('Messagerie Page Tests', () => {
    beforeEach(() => {
        // Se connecter avant de visiter la page Messagerie
        cy.visit('/login');
        cy.get('#email', { timeout: 10000 }).type('admin@admin.com');
        cy.get('#password', { timeout: 10000 }).type('admin');
        cy.contains('button', 'Log in', { timeout: 10000 }).click();

        // Attendre que la redirection vers la page Dashboard soit terminée
        cy.url().should('include', '/dashboard');

        // Naviguer vers la page Messagerie
        cy.visit('/messagerie');
        cy.url().should('include', '/messagerie');
    });

    it('devrait afficher le titre de la page Messagerie', () => {
        cy.get('h1', {timeout: 10000}).contains('Messagerie');
    });

    it('devrait afficher la barre de recherche', () => {
        cy.get('.search-bar input[type="search"]').should('be.visible');
        cy.get('.search-bar button').should('be.visible');
    });

    it('devrait afficher l\'icône de chargement lors de la récupération des utilisateurs', () => {
        cy.get('.loading-icon').should('be.visible');
    });

    it('devrait afficher le bon nombre d\'utilisateurs', () => {
        // Attendre que la variable `utilisateurs` soit définie
        cy.window().then((win) => {
            const utilisateurs = win.utilisateurs.value;

            // Vérifier que le nombre d'éléments avec la classe 'user' est égal à la longueur de `utilisateurs`
            cy.get('.user').should('have.length', utilisateurs.length);
        });
    });

    it('devrait filtrer les utilisateurs en fonction de la saisie de recherche', () => {
        // tape 'admin' dans la barre de recherche
        cy.get('.search-bar input[type="search"]').type('admin');
        //vérifie que pour chaque utilisateurs restants, la balise contient 'admin'
        cy.get('.user').each(($el) => {
            cy.wrap($el).contains('admin');
        });
    });

    //J'aurais aimé tester le fait que ce soit bien le bon email dans le gestionnaire de mails
    //suite au clic sur un utilisateur, mais cela ouvre obligatoirement le gestionnaire de mail,
    //ce qui fait tourner le test en boucle.
});
