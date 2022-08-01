describe('Test add role form', () => {
    const username = 'Lecturer';
    const email = 'lecturer@riadvice.tn'
    const pwd = 'password';
    beforeEach(() => {
        cy.task('database', {
            dbConfig: Cypress.env("hivelvet"),
            sql: `SELECT * FROM public.users WHERE username='Lecturer';`
        }).then((result) => {
            if (result.rows.length == 0) {
                cy.register(username, email, pwd, pwd)
            }
            cy.task('database', {
                dbConfig: Cypress.env("hivelvet"),
                sql: `UPDATE public.users SET status='active' WHERE username='Lecturer';`
            }).then(() => {
                cy.login(email, pwd)
                cy.visit('/settings/roles')
                cy.get('button#add-role-btn').click()
            })
        })
    })

    it('should loads correctly and check input fields exist', () => {
        cy.checkExistFormFields('roles')
    })

    it('should display errors when submitting empty form', () => {
        cy.checkEmptyForm('roles')
    })

    it('should display errors when submitting form with existing rolename', () => {
        cy.task('database', {
            dbConfig: Cypress.env("hivelvet"),
            sql: `SELECT name FROM public.roles;`
        }).then((result) => {
            if(result.rows.length != 0) {
                cy.get('input#roles_form_name').type(result.rows[0].name).should('have.value', result.rows[0].name)
                cy.get('button#submit-btn').click()
                cy.get('input#roles_form_name').parent().parent().parent().parent().get('div.ant-form-item-has-error').should('be.visible'); 
            }
        })
    })
})