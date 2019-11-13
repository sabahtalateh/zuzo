export function findObjectByPropRecursive(theObject, propName, propValue) {
    let result = null;
    if (theObject instanceof Array) {
        for (let i = 0; i < theObject.length; i++) {
            result = findObjectByPropRecursive(theObject[i], propName, propValue);
            if (result) {
                break;
            }
        }
    } else {
        for (let prop in theObject) {
            if (prop === propName) {
                if (theObject[prop] === propValue) {
                    return theObject;
                }
            }
            if (theObject[prop] instanceof Object || theObject[prop] instanceof Array) {
                result = findObjectByPropRecursive(theObject[prop], propName, propValue);
                if (result) {
                    break;
                }
            }
        }
    }
    return result;
}

export function setPropRecursive(theObject, propName, propValue) {
    if (theObject instanceof Array) {
        for (let i = 0; i < theObject.length; i++) {
            setPropRecursive(theObject[i], propName, propValue);
        }
    } else {
        for (let prop in theObject) {
            if (prop === propName) {
                theObject[prop] = propValue
            }
            if (theObject[prop] instanceof Object || theObject[prop] instanceof Array) {
                setPropRecursive(theObject[prop], propName, propValue);
            }
        }
    }
}
