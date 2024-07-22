export const rules = {
    required: [
        value => {
            if (!value) {
                return 'Dit veld is verplicht'
            }
            return true;
        }
    ],
    aboveZero: [
        value => {
            if (value === 0) {
                return 'Aantal moet boven 0 liggen'
            }
            return true;
        }
    ],
    minimalOne: [
        value => {
            if (value.length === 0) {
                return 'Selecteer minimaal 1 waarde'
            }
            return true;
        }
    ],
}