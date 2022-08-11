describe('The Registration Page', () => {
    beforeEach(() => {
        cy.refreshDatabase({ '--drop-views': true });
    })

    it('redirects to dashboard after login', () => {
        const user = {
            name: 'Felton Kerluke',
            email: 'your.email+fakedata11159@example.com',
            password: 'password',
            password_confirmation: 'password'
        }

        cy.visit('/register')

        cy.get('#name').type(user.name)
        cy.get('#email').type(user.email)
        cy.get('#password').type(user.password)
        cy.get('#password_confirmation').type(`${user.password_confirmation}{enter}`)

        cy.url().should('include', '/dashboard')
    });
})
