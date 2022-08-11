describe('The Login Page', () => {
    beforeEach(() => {
        cy.refreshDatabase({ '--drop-views': true });
        cy.seed();
    })

    it('redirects to dashboard after login', () => {
        const user = { email: 'admin@example.com', password: 'admin'}

        cy.visit('/login')

        cy.get('#email').type(user.email)

        cy.get('#password').type(`${user.password}{enter}`)

        cy.url().should('include', '/dashboard')
    });
});
