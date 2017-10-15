var visDir = "../wp-content/plugins/requests-manager/api/Visa/";
var gamDir = "../wp-content/plugins/requests-manager/api/Games-Manager/";

export const getGames = () => {
    return jQuery.ajax({
        url: gamDir + "GetOpenedActualGames.php",
        type: "POST"
    })
}

export const getAllVisaRecords = (contract) => {
    return jQuery.ajax({
        url: visDir + "GetAllVisaRecords.php",
        type: "POST",
        data: contract
    })
}

export const updateVisa = (contract) => {
    return jQuery.ajax({
        url: visDir + "UpdateVisa.php",
        type: "POST",
        data: contract
    })
}

export const deleteVisa = (contract) => {
    return jQuery.ajax({
        url: visDir + "DeleteVisa.php",
        type: "POST",
        data: contract
    })
}