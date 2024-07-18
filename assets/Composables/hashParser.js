/**
 * Parses the window.hash and redirects if the hash is accepted
 */
export class HashParser {
    constructor(router) {
        this.router = router;
        this.prefix = 'recipe'
    }

    extractHash(hash) {
        hash = hash.replace('#', '');

        let parts = atob(hash).split('-');
        if (parts[0] === this.prefix && parts[1] > 0) {
            return parts[1];
        }
        return 0;
    }

    redirect (hash) {
        let id = this.extractHash(hash);

        if (id) {
            this.router.push({name:'recipeView', params: {id: id}})
        }
    }

    install() {
        if (window.location.hash) {
            this.redirect(window.location.hash)
        }

        // window.addEventListener('hashchange', ()=> {
        //     this.redirect(window.location.hash)
        // })
    }

    buildHash(id) {
        return btoa(this.prefix + '-' + id)
    }
}


