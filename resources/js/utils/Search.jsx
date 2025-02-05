import React, { useState, useEffect, useRef } from "react";
import axios from "axios";
import { Link } from "react-router-dom";

const Search = ({ isSearchOpen, setIsSearchOpen, currentVersion }) => {
    const [searchQuery, setSearchQuery] = useState("");
    const [searchResults, setSearchResults] = useState({ topics: [], block_types: [], topic_blocks: [] });
    const [isLoading, setIsLoading] = useState(false);
    const inputRef = useRef(null);

    useEffect(() => {
        if (!currentVersion) return;

        if (isSearchOpen) {
            inputRef.current?.focus();
        }
    }, [isSearchOpen, currentVersion]);

    useEffect(() => {
        if (searchQuery.trim() === "") {
            setSearchResults({ topics: [], block_types: [], topic_blocks: [] });
            return;
        }

        const timer = setTimeout(async () => {
            setIsLoading(true);
            try {
                const response = await axios.get(`/api/version/${currentVersion}/search`, {
                    params: { query: searchQuery },
                });
                setSearchResults(response.data);
            } catch (error) {
                console.error("Error fetching search results:", error);
            } finally {
                setIsLoading(false);
            }
        }, 500);

        return () => clearTimeout(timer);
    }, [searchQuery]);

    const handleSearchChange = (e) => {
        setSearchQuery(e.target.value);
    };

    const handleResultClick = () => {
        setIsSearchOpen(false);
        setSearchQuery(""); // Reset search query when closing
    };

    const highlightText = (text) => {
        if (!searchQuery.trim()) return text;
        const regex = new RegExp(`(${searchQuery.trim()})`, "gi");
        return text.split(regex).map((part, index) =>
            part.toLowerCase() === searchQuery.trim().toLowerCase() ? (
                <span key={index} className="font-bold text-theme-lightText dark:text-theme-darkText">{part}</span>
            ) : (
                part
            )
        );
    };

    return (
        <div
            className="fixed inset-0 bg-theme-dark bg-opacity-90 flex justify-center items-start z-20"
            onClick={() => setIsSearchOpen(false)}
        >
            <div
                className="relative w-full max-w-lg sm:max-w-md md:max-w-xl lg:max-w-lg xl:max-w-2xl top-[20%] p-6 sm:p-8 bg-theme-light dark:bg-gray-900 rounded-lg max-h-[80vh] overflow-auto mx-4 sm:mx-6 md:mx-8"
                onClick={(e) => e.stopPropagation()}
            >
                <input
                    ref={inputRef}
                    type="text"
                    placeholder="Search..."
                    value={searchQuery}
                    onChange={handleSearchChange}
                    className="w-full px-4 py-2 bg-theme-light dark:bg-theme-dark text-theme-lightText dark:text-theme-darkText rounded-lg focus:outline-none focus:ring-1 focus:ring-theme"
                />

                {isLoading && <p className="text-theme-lightText dark:text-theme-darkText">Loading...</p>}

                {searchResults.topics.length > 0 && (
                    <div className="mt-2">
                        {searchResults.topics.map((result) => (
                            <Link key={result.id} to={`/${result.slug}`} className="text-theme-lightText dark:text-theme-darkText">
                                <div
                                    className="p-2 hover:bg-theme-accent dark:hover:bg-theme-dark cursor-pointer border-b border-theme-dark rounded-none transition-colors duration-200"
                                    onClick={handleResultClick}
                                >
                                    {highlightText(`#${result.name}`)}
                                </div>
                            </Link>
                        ))}
                    </div>
                )}

                {searchResults.topic_blocks.length > 0 && (
                    <div className="mt-2">
                        {searchResults.topic_blocks.map((result) => {
                            const attributes = JSON.parse(result.attributes);
                            const matchedContent = Object.entries(attributes).filter(([key, value]) => {
                                return typeof value === "string" && value.toLowerCase().includes(searchQuery.toLowerCase());
                            });

                            return matchedContent.length > 0 ? (
                                <Link key={result.id} to={`/${result.topic.slug}/blocks/${result.id}`} className="text-theme-lightText dark:text-theme-darkText">
                                    <div
                                        className="p-2 hover:bg-theme-accent dark:hover:bg-theme-dark cursor-pointer border-b border-theme-dark rounded-none transition-colors duration-200"
                                        onClick={handleResultClick}
                                    >
                                        {matchedContent.map(([key, value], index) => {
                                            const plainText = value.replace(/<\/?[^>]+(>|$)/g, "");
                                            return (
                                                <div key={index}>
                                                    {highlightText(plainText)}
                                                </div>
                                            );
                                        })}
                                        <div className="mt-2 text-xs flex justify-between text-theme-lightText dark:text-theme-darkText">
                                            <span className="text-theme-lightText dark:text-theme-darkText">#{result.topic.name}</span>
                                            {result.topic.versioning && result.topic.versioning.identifier && (
                                                <span className="text-theme-lightText dark:text-theme-darkText">V {result.topic.versioning.identifier}</span>
                                            )}
                                        </div>
                                    </div>
                                </Link>
                            ) : null;
                        })}
                    </div>
                )}

                {searchQuery.trim() !== "" && !isLoading && searchResults.topics.length === 0 && searchResults.topic_blocks.length === 0 && (
                    <p className="text-theme-lightText dark:text-theme-darkText mt-2">No results found.</p>
                )}

                <div className="text-right text-xs text-theme-lightText dark:text-theme-darkText mt-4">Search in <strong>WisenDocs</strong></div>
            </div>
        </div>
    );
};

export default Search;