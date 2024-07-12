export const calculateDuration = (minutes) => {
    let h = Math.floor(minutes / 60);
    let m = minutes % 60;
    return h > 0 ? h + ' uur ' + m + ' min' : m + ' min';
}