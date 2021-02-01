import React from 'react';

const Pagination = ({currentPage,itemsPerPage, length, onPageChanged}) => {

    const pagesCount   = Math.ceil(length / itemsPerPage) + 1;
    const pages        = [];

    for (let i = 1; i < pagesCount; i++) {
        pages.push(i);
    }

    return (  
        <ul className="md-ui component-pagination">
            {currentPage > 1 &&
                <li className="pagination-arrow arrow-left">
                    <i className="material-icons" onClick={() => onPageChanged(currentPage - 1)}>&laquo;</i>
                </li>
            }
            {pages.map(page => 
                <li key={page} className={"pagination-number" + (currentPage === page && " current-number")} onClick={() => onPageChanged(page)}>
                    {page}
                </li>
            )}
            
            {currentPage <= pagesCount - 2  && 
            <li className="pagination-arrow arrow-right">
                <i className="material-icons" onClick={() => onPageChanged(currentPage + 1)}>&raquo;</i>
            </li>
            }  
        </ul>
    );
}

Pagination.getData = (items, currentPage, itemsPerPage) =>{
    const start = currentPage * itemsPerPage - itemsPerPage;
    return items.slice(start, start + itemsPerPage);
}
 
export default Pagination;